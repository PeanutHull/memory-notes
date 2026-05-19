---
name: safe-prod-mysql-query
description: Safely inspect production MySQL data on the `live`, `dbj`, and `dbj-tdc` instances with readonly guardrails, table discovery, row-count and index triage, and mandatory user confirmation before business `SELECT` queries. Use when Codex needs to locate candidate tables, inspect schema or indexes, validate SQL safety, or run confirmed readonly SQL against these online MySQL instances.
---

# Safe Prod MySQL Query

## Overview

Use this skill to query the three online MySQL instances without drifting into write SQL, temp-table workflows, or blind large-table scans. Treat metadata discovery as safe-by-default, but treat every real business `SELECT` as confirmation-gated work.

The bundled script is `scripts/prod_mysql.php`. It handles database discovery, table discovery, table size and index inspection, SQL validation, and readonly execution.

## Workflow

1. Confirm the target instance first. If the user did not say `live`, `dbj`, or `dbj-tdc`, stop and ask. Never guess.
2. Start from the instance default database.
   `live` -> `ds_live_class`
   `dbj` -> `doubanjiang`
   `dbj-tdc` -> `doubanjiang`
3. Discover metadata before writing any business SQL.
   Use `list-databases`, `find-table`, and `table-info`.
   Do not ask for confirmation for database listing, table discovery, row-count inspection, column inspection, or index inspection.
4. Search fallback databases only when the default database does not contain the target table.
   Stay on the same instance.
   Exclude `mysql`, `information_schema`, `performance_schema`, `sys`, and vendor-managed system databases such as `__tencentdb__`.
5. Inspect table size before planning the business query.
   `table-info` returns the engine row estimate from `SHOW TABLE STATUS` plus index details from `SHOW INDEX`.
   Treat `estimated_rows > 2000000` as large-table mode.
6. In large-table mode, shape the business query around indexes before asking for approval.
   Prefer indexed equality/range predicates.
   Prefer explicit columns over `SELECT *`.
   Prefer a `LIMIT` unless the user explicitly needs a full result or aggregate.
   Avoid full-table scans, cross-database joins, and wide result sets unless the user explicitly insists and has seen the risk note.
7. Before every real business SQL execution, send the user one confirmation block with:
   instance
   database
   target tables
   estimated row counts
   relevant indexes
   exact SQL text
8. Run the business SQL only after the user confirms.
   Use `validate-sql` first, then `run-sql`.
   `run-sql` opens a readonly transaction and rolls it back after reading the result set.

## Guardrails

- Allow only readonly SQL in business execution: `SELECT`, `WITH ... SELECT`, or `EXPLAIN SELECT`.
- Reject any SQL that contains DML, DDL, DCL, session-changing business text, temp-table creation, locking reads, file export, or system-schema access.
- Reject multiple statements.
- Reject `FOR UPDATE`, `LOCK IN SHARE MODE`, `INTO OUTFILE`, `INTO DUMPFILE`, and `LOAD_FILE()`.
- Do not use temporary tables, even for intermediate analysis.
- Do not browse MySQL system schemas or vendor-managed system databases for business data.
- Do not skip instance confirmation.
- Do not run business SQL before showing the exact SQL to the user.

## Command Set

- `php scripts/prod_mysql.php list-databases --instance live`
- `php scripts/prod_mysql.php find-table --instance live --table lesson`
- `php scripts/prod_mysql.php find-table --instance live --keyword lesson`
- `php scripts/prod_mysql.php table-info --instance live --table lesson`
- `php scripts/prod_mysql.php validate-sql --sql "SELECT id, name FROM lesson WHERE id = 1 LIMIT 1"`
- `php scripts/prod_mysql.php run-sql --instance live --database ds_live_class --sql "SELECT id, name FROM lesson WHERE id = 1 LIMIT 1"`

Read `references/commands.md` when you need fuller command examples and the confirmation template.

## Confirmation Template

Use this template before `run-sql`:

```text
请确认执行以下业务 SQL
实例: <live|dbj|dbj-tdc>
数据库: <database>
目标表: <table1, table2, ...>
表规模: <table -> estimated_rows>
相关索引: <index summary>
SQL:
<exact SQL>
```

## Validation Checklist

- Confirm the instance before touching metadata.
- Confirm the default database first, then search other non-system databases on the same instance only if needed.
- Confirm `table-info` was reviewed before building the business SQL.
- Confirm large-table queries mention the chosen index path or an explicit reason for the scan.
- Confirm the SQL passed `validate-sql`.
- Confirm the exact SQL was shown to the user before `run-sql`.
