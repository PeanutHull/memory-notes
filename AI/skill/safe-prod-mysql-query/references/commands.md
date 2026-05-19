# Commands

Set the skill path once when you are working outside the skill directory:

```bash
export SAFE_MYSQL_SKILL="${CODEX_HOME:-$HOME/.codex}/skills/safe-prod-mysql-query"
```

## Metadata-first workflow

List non-system databases on an instance:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" list-databases --instance live
```

Find an exact table name in the default database first, then fall back to other non-system databases on the same instance:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" find-table --instance live --table ds_class_student
```

Search by keyword when the exact table name is unknown:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" find-table --instance live --keyword class
```

Inspect estimated rows, columns, and indexes:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" table-info --instance live --table ds_class_student
```

Inspect a table in a non-default database after discovery:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" table-info --instance dbj --database analytics --table user_orders
```

## Business SQL workflow

Validate the SQL before sending it to the user:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" validate-sql --sql "SELECT id, user_id FROM ds_class_student WHERE class_id = 123 LIMIT 20"
```

After the user confirms the exact SQL, run it in readonly mode:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" run-sql --instance live --database ds_live_class --sql "SELECT id, user_id FROM ds_class_student WHERE class_id = 123 LIMIT 20"
```

Use `--sql-file` when the statement is too long for shell quoting:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" validate-sql --sql-file /tmp/query.sql
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" run-sql --instance live --database ds_live_class --sql-file /tmp/query.sql
```

Ask for JSON output when the result needs further machine processing:

```bash
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" table-info --instance live --table ds_class_student --format json
php "$SAFE_MYSQL_SKILL/scripts/prod_mysql.php" run-sql --instance live --database ds_live_class --sql "SELECT COUNT(*) AS cnt FROM ds_class_student WHERE class_id = 123" --format json
```

## Confirmation Template

Use this exact structure before `run-sql`:

```text
请确认执行以下业务 SQL
实例: live
数据库: ds_live_class
目标表: ds_class_student
表规模: ds_class_student -> 184352
相关索引: PRIMARY(id); idx_class_id(class_id)
SQL:
SELECT id, user_id
FROM ds_class_student
WHERE class_id = 123
LIMIT 20
```

## Interpretation Rules

- `list-databases`, `find-table`, and `table-info` are metadata steps and do not require user confirmation.
- Treat `__tencentdb__` the same way as `mysql` system schemas: discovery may see it, but business lookup must exclude it.
- `run-sql` is the only step that executes business SQL. Always show the exact SQL first.
- When `estimated_rows > 2000000`, explain which index or predicate keeps the query selective before asking for approval.
