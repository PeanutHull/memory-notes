#!/usr/bin/env php
<?php

declare(strict_types=1);

const INSTANCES = [
    'live' => [
        'host' => '10.0.4.43',
        'port' => 3306,
        'user' => 'live_class_r',
        'pass' => 'CrcP8XipvlFmtJbN',
        'default_db' => 'ds_live_class',
    ],
    'dbj' => [
        'host' => '10.0.0.31',
        'port' => 3306,
        'user' => 'dyxc_r',
        'pass' => 'Douyuxc@2021',
        'default_db' => 'doubanjiang',
    ],
    'dbj-tdc' => [
        'host' => '10.0.0.94',
        'port' => 3306,
        'user' => 'dyxc_r',
        'pass' => 'Douyuxc@2021',
        'default_db' => 'doubanjiang',
    ],
];

const SYSTEM_DATABASES = ['information_schema', 'mysql', 'performance_schema', 'sys', '__tencentdb__'];
const LARGE_TABLE_THRESHOLD = 2000000;

main($argv);

function main(array $argv): void
{
    $parsed = parseArgs($argv);
    $command = $parsed['command'];
    $options = $parsed['options'];
    $format = strtolower((string)($options['format'] ?? 'text'));

    if ($command === null) {
        usage(1);
    }

    switch ($command) {
        case 'list-databases':
            $instance = requireInstance($options);
            $pdo = connectInstance($instance, null, true);
            $databases = listDatabases($pdo);
            render($format, [
                'instance' => $instance,
                'default_database' => INSTANCES[$instance]['default_db'],
                'databases' => array_values($databases),
            ], function (array $payload): void {
                echo "instance: {$payload['instance']}\n";
                echo "default_database: {$payload['default_database']}\n";
                echo "databases:\n";
                foreach ($payload['databases'] as $database) {
                    echo "- {$database}\n";
                }
            });
            return;

        case 'find-table':
            $instance = requireInstance($options);
            $exactTable = isset($options['table']) ? trim((string)$options['table']) : null;
            $keyword = isset($options['keyword']) ? trim((string)$options['keyword']) : null;
            if ($exactTable === null && $keyword === null) {
                fail('find-table requires --table or --keyword');
            }
            $pdo = connectInstance($instance, null, true);
            $matches = findTables(
                $pdo,
                $instance,
                isset($options['database']) ? (string)$options['database'] : null,
                $exactTable,
                $keyword
            );
            render($format, [
                'instance' => $instance,
                'default_database' => INSTANCES[$instance]['default_db'],
                'search_database' => isset($options['database']) ? (string)$options['database'] : null,
                'exact_table' => $exactTable,
                'keyword' => $keyword,
                'matches' => $matches,
            ], function (array $payload): void {
                echo "instance: {$payload['instance']}\n";
                echo "default_database: {$payload['default_database']}\n";
                if ($payload['search_database'] !== null) {
                    echo "search_database: {$payload['search_database']}\n";
                }
                if ($payload['exact_table'] !== null) {
                    echo "exact_table: {$payload['exact_table']}\n";
                }
                if ($payload['keyword'] !== null) {
                    echo "keyword: {$payload['keyword']}\n";
                }
                if (count($payload['matches']) === 0) {
                    echo "matches: none\n";
                    return;
                }
                echo "matches:\n";
                foreach ($payload['matches'] as $match) {
                    echo "- {$match['database']}.{$match['table']}\n";
                }
            });
            return;

        case 'table-info':
            $instance = requireInstance($options);
            $table = requireOption($options, 'table');
            $database = isset($options['database']) ? (string)$options['database'] : null;
            $pdo = connectInstance($instance, null, true);
            $targets = resolveTableTargets($pdo, $instance, $database, $table);
            $details = [];
            foreach ($targets as $target) {
                $details[] = getTableInfo($pdo, $instance, $target['database'], $target['table']);
            }
            render($format, [
                'instance' => $instance,
                'requested_table' => $table,
                'details' => $details,
            ], function (array $payload): void {
                echo "instance: {$payload['instance']}\n";
                echo "requested_table: {$payload['requested_table']}\n";
                if (count($payload['details']) === 0) {
                    echo "details: none\n";
                    return;
                }
                foreach ($payload['details'] as $detail) {
                    echo "---\n";
                    echo "database: {$detail['database']}\n";
                    echo "table: {$detail['table']}\n";
                    echo "engine: {$detail['engine']}\n";
                    echo "estimated_rows: {$detail['estimated_rows']}\n";
                    echo "large_table_mode: " . ($detail['large_table_mode'] ? 'yes' : 'no') . "\n";
                    echo "data_length: {$detail['data_length']}\n";
                    echo "index_length: {$detail['index_length']}\n";
                    echo "columns:\n";
                    foreach ($detail['columns'] as $column) {
                        echo "- {$column['Field']} {$column['Type']} null={$column['Null']} key={$column['Key']}\n";
                    }
                    echo "indexes:\n";
                    foreach ($detail['indexes'] as $index) {
                        echo "- {$index['name']} " . ($index['unique'] ? 'UNIQUE' : 'NON_UNIQUE') . " (" . implode(', ', $index['columns']) . ")\n";
                    }
                }
            });
            return;

        case 'validate-sql':
            $sql = readSql($options);
            $mode = strtolower((string)($options['mode'] ?? 'business'));
            $validation = validateSql($sql, $mode);
            $exitCode = $validation['valid'] ? 0 : 2;
            render($format, $validation, function (array $payload): void {
                echo 'valid: ' . ($payload['valid'] ? 'yes' : 'no') . "\n";
                if (count($payload['errors']) > 0) {
                    echo "errors:\n";
                    foreach ($payload['errors'] as $error) {
                        echo "- {$error}\n";
                    }
                }
                if (count($payload['warnings']) > 0) {
                    echo "warnings:\n";
                    foreach ($payload['warnings'] as $warning) {
                        echo "- {$warning}\n";
                    }
                }
                echo "normalized_sql:\n{$payload['normalized_sql']}\n";
            });
            exit($exitCode);

        case 'run-sql':
            $instance = requireInstance($options);
            $database = (string)($options['database'] ?? INSTANCES[$instance]['default_db']);
            if (isSystemDatabase($database)) {
                fail('run-sql cannot target a system database');
            }
            $sql = readSql($options);
            $validation = validateSql($sql, 'business');
            if (!$validation['valid']) {
                render($format, $validation, function (array $payload): void {
                    echo "SQL validation failed.\n";
                    foreach ($payload['errors'] as $error) {
                        echo "- {$error}\n";
                    }
                });
                exit(2);
            }
            $maxRows = isset($options['max-rows']) ? max(1, (int)$options['max-rows']) : 2000;
            $pdo = connectInstance($instance, $database, false);
            $result = runReadonlyQuery($pdo, $sql, $maxRows);
            $payload = [
                'instance' => $instance,
                'database' => $database,
                'max_rows' => $maxRows,
                'warnings' => $validation['warnings'],
                'result' => $result,
                'normalized_sql' => $validation['normalized_sql'],
            ];
            render($format, $payload, function (array $data): void {
                echo "instance: {$data['instance']}\n";
                echo "database: {$data['database']}\n";
                echo "max_rows: {$data['max_rows']}\n";
                if (count($data['warnings']) > 0) {
                    echo "warnings:\n";
                    foreach ($data['warnings'] as $warning) {
                        echo "- {$warning}\n";
                    }
                }
                echo "row_count_returned: {$data['result']['row_count_returned']}\n";
                echo "truncated: " . ($data['result']['truncated'] ? 'yes' : 'no') . "\n";
                if ($data['result']['columns'] !== []) {
                    echo "columns: " . implode(', ', $data['result']['columns']) . "\n";
                }
                echo "rows:\n";
                foreach ($data['result']['rows'] as $row) {
                    echo json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
                }
            });
            return;

        default:
            fail("unknown command: {$command}");
    }
}

function usage(int $code): void
{
    $script = basename(__FILE__);
    $message = <<<TXT
Usage:
  php {$script} list-databases --instance <live|dbj|dbj-tdc> [--format json]
  php {$script} find-table --instance <name> [--database <db>] (--table <name> | --keyword <kw>) [--format json]
  php {$script} table-info --instance <name> [--database <db>] --table <name> [--format json]
  php {$script} validate-sql --sql "<select ...>" [--mode business|metadata] [--format json]
  php {$script} validate-sql --sql-file /path/to/query.sql [--mode business|metadata] [--format json]
  php {$script} run-sql --instance <name> [--database <db>] (--sql "<select ...>" | --sql-file /path/to/query.sql) [--max-rows 2000] [--format json]
TXT;
    fwrite($code === 0 ? STDOUT : STDERR, $message . "\n");
    exit($code);
}

function parseArgs(array $argv): array
{
    $command = null;
    $options = [];
    $count = count($argv);
    for ($i = 1; $i < $count; $i++) {
        $arg = $argv[$i];
        if ($command === null && strpos($arg, '--') !== 0) {
            $command = $arg;
            continue;
        }
        if (strpos($arg, '--') !== 0) {
            fail("unexpected positional argument: {$arg}");
        }
        $token = substr($arg, 2);
        $eqPos = strpos($token, '=');
        if ($eqPos !== false) {
            $key = substr($token, 0, $eqPos);
            $value = substr($token, $eqPos + 1);
            $options[$key] = $value;
            continue;
        }
        $key = $token;
        $next = $argv[$i + 1] ?? null;
        if ($next !== null && strpos($next, '--') !== 0) {
            $options[$key] = $next;
            $i++;
            continue;
        }
        $options[$key] = true;
    }
    return ['command' => $command, 'options' => $options];
}

function requireInstance(array $options): string
{
    $instance = isset($options['instance']) ? (string)$options['instance'] : '';
    if ($instance === '') {
        fail('missing required option: --instance');
    }
    if (!isset(INSTANCES[$instance])) {
        fail("unknown instance: {$instance}");
    }
    return $instance;
}

function requireOption(array $options, string $name): string
{
    $value = isset($options[$name]) ? trim((string)$options[$name]) : '';
    if ($value === '') {
        fail("missing required option: --{$name}");
    }
    return $value;
}

function connectInstance(string $instance, ?string $database, bool $buffered): PDO
{
    $config = INSTANCES[$instance];
    $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';charset=utf8mb4';
    if ($database !== null) {
        $dsn .= ';dbname=' . $database;
    }
    return new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 5,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => $buffered,
    ]);
}

function listDatabases(PDO $pdo): array
{
    $rows = $pdo->query('SHOW DATABASES')->fetchAll();
    $databases = [];
    foreach ($rows as $row) {
        $database = reset($row);
        if ($database === false) {
            continue;
        }
        $database = (string)$database;
        if (!isSystemDatabase($database)) {
            $databases[] = $database;
        }
    }
    sort($databases);
    return $databases;
}

function isSystemDatabase(string $database): bool
{
    return in_array(strtolower($database), SYSTEM_DATABASES, true);
}

function candidateDatabases(array $databases, string $instance, ?string $database): array
{
    if ($database !== null && $database !== '') {
        if (isSystemDatabase($database)) {
            fail('system databases are not allowed here');
        }
        return [$database];
    }
    $default = INSTANCES[$instance]['default_db'];
    $ordered = [];
    if (in_array($default, $databases, true)) {
        $ordered[] = $default;
    }
    foreach ($databases as $db) {
        if ($db !== $default) {
            $ordered[] = $db;
        }
    }
    return $ordered;
}

function showTables(PDO $pdo, string $database): array
{
    $sql = 'SHOW FULL TABLES FROM ' . quoteIdentifier($database);
    $rows = $pdo->query($sql)->fetchAll();
    $tables = [];
    foreach ($rows as $row) {
        $values = array_values($row);
        if (count($values) < 2) {
            continue;
        }
        $tables[] = [
            'table' => (string)$values[0],
            'type' => (string)$values[1],
        ];
    }
    return $tables;
}

function findTables(PDO $pdo, string $instance, ?string $database, ?string $exactTable, ?string $keyword): array
{
    $databases = candidateDatabases(listDatabases($pdo), $instance, $database);
    $matches = [];
    foreach ($databases as $db) {
        $inDb = [];
        foreach (showTables($pdo, $db) as $tableInfo) {
            if (strcasecmp($tableInfo['type'], 'BASE TABLE') !== 0) {
                continue;
            }
            $table = $tableInfo['table'];
            $matched = false;
            if ($exactTable !== null) {
                $matched = strcasecmp($table, $exactTable) === 0;
            } elseif ($keyword !== null) {
                $matched = stripos($table, $keyword) !== false;
            }
            if ($matched) {
                $inDb[] = ['database' => $db, 'table' => $table];
            }
        }
        if ($inDb !== []) {
            $matches = array_merge($matches, $inDb);
            if ($exactTable !== null && $database === null) {
                break;
            }
        }
    }
    return $matches;
}

function resolveTableTargets(PDO $pdo, string $instance, ?string $database, string $table): array
{
    if ($database !== null && $database !== '') {
        return [['database' => $database, 'table' => $table]];
    }
    $matches = findTables($pdo, $instance, null, $table, null);
    if ($matches === []) {
        fail("table not found on instance {$instance}: {$table}");
    }
    return $matches;
}

function getTableInfo(PDO $pdo, string $instance, string $database, string $table): array
{
    if (isSystemDatabase($database)) {
        fail('system databases are not allowed here');
    }
    $statusSql = 'SHOW TABLE STATUS FROM ' . quoteIdentifier($database) . ' LIKE ' . $pdo->quote($table);
    $status = $pdo->query($statusSql)->fetch();
    if ($status === false) {
        fail("table not found: {$database}.{$table}");
    }
    $columnsSql = 'SHOW FULL COLUMNS FROM ' . quoteIdentifier($database) . '.' . quoteIdentifier($table);
    $columns = $pdo->query($columnsSql)->fetchAll();
    $indexesSql = 'SHOW INDEX FROM ' . quoteIdentifier($database) . '.' . quoteIdentifier($table);
    $indexRows = $pdo->query($indexesSql)->fetchAll();
    $indexes = normalizeIndexes($indexRows);

    return [
        'instance' => $instance,
        'database' => $database,
        'table' => $table,
        'engine' => (string)($status['Engine'] ?? ''),
        'estimated_rows' => (int)($status['Rows'] ?? 0),
        'large_table_mode' => ((int)($status['Rows'] ?? 0)) > LARGE_TABLE_THRESHOLD,
        'data_length' => (int)($status['Data_length'] ?? 0),
        'index_length' => (int)($status['Index_length'] ?? 0),
        'comment' => (string)($status['Comment'] ?? ''),
        'columns' => $columns,
        'indexes' => $indexes,
    ];
}

function normalizeIndexes(array $rows): array
{
    $grouped = [];
    foreach ($rows as $row) {
        $name = (string)$row['Key_name'];
        if (!isset($grouped[$name])) {
            $grouped[$name] = [
                'name' => $name,
                'unique' => ((int)$row['Non_unique']) === 0,
                'columns' => [],
            ];
        }
        $seq = (int)$row['Seq_in_index'];
        $grouped[$name]['columns'][$seq] = (string)$row['Column_name'];
    }
    foreach ($grouped as &$index) {
        ksort($index['columns']);
        $index['columns'] = array_values($index['columns']);
    }
    unset($index);
    return array_values($grouped);
}

function readSql(array $options): string
{
    $hasInline = isset($options['sql']);
    $hasFile = isset($options['sql-file']);
    if ($hasInline === $hasFile) {
        fail('provide exactly one of --sql or --sql-file');
    }
    if ($hasInline) {
        $sql = (string)$options['sql'];
    } else {
        $path = (string)$options['sql-file'];
        if (!is_file($path)) {
            fail("sql file not found: {$path}");
        }
        $sql = (string)file_get_contents($path);
    }
    $sql = trim($sql);
    if ($sql === '') {
        fail('SQL cannot be empty');
    }
    return $sql;
}

function validateSql(string $sql, string $mode): array
{
    $normalized = normalizeSql($sql);
    $errors = [];
    $warnings = [];

    if ($normalized === '') {
        $errors[] = 'SQL is empty after removing comments';
        return buildValidationResult(false, $normalized, $errors, $warnings);
    }

    if (strpos($normalized, ';') !== false) {
        $errors[] = 'Multiple statements are not allowed';
    }

    $lower = strtolower($normalized);
    $allowed = false;
    if ($mode === 'business') {
        $allowed = preg_match('/^(select|with)\b/i', $normalized) === 1
            || preg_match('/^explain\s+(select|with)\b/i', $normalized) === 1;
        if (!$allowed) {
            $errors[] = 'Business SQL must start with SELECT, WITH, or EXPLAIN SELECT';
        }
    } elseif ($mode === 'metadata') {
        $allowed = preg_match('/^(show|desc|describe|explain\s+(select|with))\b/i', $normalized) === 1;
        if (!$allowed) {
            $errors[] = 'Metadata SQL must start with SHOW, DESC, DESCRIBE, or EXPLAIN SELECT';
        }
    } else {
        $errors[] = "Unknown validation mode: {$mode}";
    }

    $forbiddenPatterns = [
        '/\b(insert|update|delete|replace|alter|drop|truncate|rename|grant|revoke|optimize|analyze|repair|flush|call|execute|prepare|deallocate|handler|purge|reset|shutdown|kill)\b/i' => 'Write or administrative SQL is not allowed',
        '/\bcreate\b/i' => 'CREATE statements are not allowed',
        '/\btemporary\s+table\b/i' => 'Temporary tables are not allowed',
        '/\bfor\s+update\b/i' => 'Locking reads are not allowed',
        '/\block\s+in\s+share\s+mode\b/i' => 'Locking reads are not allowed',
        '/\binto\s+(out|dump)file\b/i' => 'File export is not allowed',
        '/\bload_file\s*\(/i' => 'Filesystem reads are not allowed',
        '/\b(load\s+data|outfile|dumpfile)\b/i' => 'External file operations are not allowed',
        '/\b(mysql|information_schema|performance_schema|sys)\s*\./i' => 'System schemas are not allowed in SQL',
    ];
    foreach ($forbiddenPatterns as $pattern => $message) {
        if (preg_match($pattern, $normalized) === 1) {
            $errors[] = $message;
        }
    }

    if (preg_match('/^\s*select\s+\*/i', $normalized) === 1) {
        $warnings[] = 'SELECT * increases scan width; prefer explicit columns';
    }
    if (stripos($lower, ' limit ') === false && preg_match('/\b(count|sum|min|max|avg)\s*\(/i', $normalized) !== 1) {
        $warnings[] = 'No LIMIT detected; confirm the result size is bounded';
    }
    if (stripos($lower, ' where ') === false && preg_match('/\b(count|sum|min|max|avg)\s*\(/i', $normalized) !== 1) {
        $warnings[] = 'No WHERE clause detected; confirm a full scan is acceptable';
    }

    return buildValidationResult(count($errors) === 0, $normalized, uniqueList($errors), uniqueList($warnings));
}

function buildValidationResult(bool $valid, string $normalized, array $errors, array $warnings): array
{
    return [
        'valid' => $valid,
        'normalized_sql' => $normalized,
        'errors' => $errors,
        'warnings' => $warnings,
    ];
}

function normalizeSql(string $sql): string
{
    $sql = preg_replace('/\/\*.*?\*\//s', ' ', $sql);
    $sql = preg_replace('/^\s*(--|#).*$\R?/m', ' ', (string)$sql);
    $sql = trim((string)$sql);
    $sql = rtrim($sql, " \t\n\r\0\x0B;");
    $sql = preg_replace('/\s+/', ' ', $sql);
    return trim((string)$sql);
}

function runReadonlyQuery(PDO $pdo, string $sql, int $maxRows): array
{
    $pdo->exec('SET SESSION TRANSACTION READ ONLY');
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->query($sql);
        $columns = [];
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $meta = $stmt->getColumnMeta($i);
            $columns[] = isset($meta['name']) ? (string)$meta['name'] : 'col_' . $i;
        }

        $rows = [];
        $truncated = false;
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
            $rows[] = $row;
            if (count($rows) >= $maxRows) {
                $nextRow = $stmt->fetch(PDO::FETCH_ASSOC);
                $truncated = $nextRow !== false;
                break;
            }
        }
        $stmt->closeCursor();
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return [
            'columns' => $columns,
            'row_count_returned' => count($rows),
            'truncated' => $truncated,
            'rows' => $rows,
        ];
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        fail('query failed: ' . $e->getMessage());
    }
}

function quoteIdentifier(string $identifier): string
{
    return '`' . str_replace('`', '``', $identifier) . '`';
}

function uniqueList(array $items): array
{
    return array_values(array_unique($items));
}

function render(string $format, array $payload, callable $textRenderer): void
{
    if ($format === 'json') {
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
        return;
    }
    $textRenderer($payload);
}

function fail(string $message): void
{
    fwrite(STDERR, $message . "\n");
    exit(1);
}
