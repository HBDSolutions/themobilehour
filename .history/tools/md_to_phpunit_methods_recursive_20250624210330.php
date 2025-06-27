<?php
/**
 * Usage: php tools/md_to_phpunit_methods_recursive.php <root_folder>
 * 
 * Scans all subdirectories for .md files, and generates PHPUnit test methods.
 * Prints all generated methods for easy copy-paste.
 */

if ($argc < 2) {
    echo "Usage: php tools/md_to_phpunit_methods_recursive.php <root_folder>\n";
    exit(1);
}

$rootDir = rtrim($argv[1], '/');
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootDir));

foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (strtolower($file->getExtension()) !== 'md') continue;

    $mdFile = $file->getPathname();
    [$title, $userStory, $scenarios] = parseMarkdown($mdFile);

    echo "// From: {$mdFile}\n";
    foreach ($scenarios as $scenario) {
        $traceId = getTraceId($scenario);
        $desc = getScenarioDesc($scenario);
        $methodName = "test_" . strtolower(str_replace('.', '_', $traceId)) . "_" . snakeCase($desc);
        [$given, $when, $then] = inferBddSteps($desc);
        $testCode = generateTestCode($desc);
        echo <<<PHP
public function {$methodName}()
{
    // Given {$given}
    // When {$when}
    // Then {$then}
{$testCode}
}

PHP;
    }
}

// --- Helper functions (same as previous script) ---

function parseMarkdown($file) {
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $title = '';
    $userStory = '';
    $scenarios = [];
    $inUserStory = false;
    $inScenarios = false;

    foreach ($lines as $line) {
        if (preg_match('/^# (.+)/', $line, $m)) {
            $title = trim($m[1]);
        } elseif (stripos($line, '## user story') === 0) {
            $inUserStory = true;
            $inScenarios = false;
        } elseif (stripos($line, '## scenarios') === 0) {
            $inUserStory = false;
            $inScenarios = true;
        } elseif ($inUserStory && trim($line) !== '') {
            $userStory .= ' ' . trim($line);
        } elseif ($inScenarios && preg_match('/^- (.+)/', $line, $m)) {
            $scenarios[] = trim($m[1]);
        }
    }
    return [trim($title), trim($userStory), $scenarios];
}

function getTraceId($scenarioLine) {
    if (preg_match('/^([0-9\.]+):/', $scenarioLine, $m)) {
        return $m[1];
    }
    return 'X';
}

function getScenarioDesc($scenarioLine) {
    return preg_replace('/^[0-9\.]+:\s*/', '', $scenarioLine);
}

function snakeCase($str) {
    return strtolower(preg_replace('/[^a-z0-9]+/', '_', $str));
}

function inferBddSteps($desc) {
    $given = "the system is set up";
    if (stripos($desc, 'exists') !== false) {
        $when = "the system is checked for: " . strtolower($desc);
        $then = $desc;
    } elseif (stripos($desc, 'accessible') !== false) {
        $when = "the application tries to access the database";
        $then = $desc;
    } else {
        $when = "the relevant operation is performed";
        $then = $desc;
    }
    return [$given, $when, $then];
}

function generateTestCode($desc) {
    $lines = [];
    if (stripos($desc, 'database exists') !== false) {
        $lines[] = "    \$databases = get_mysql_databases();";
        $lines[] = "    \$this->assertContains('app_db', \$databases, \"Database 'app_db' should exist in MySQL.\");";
    } elseif (stripos($desc, 'schema') !== false) {
        $lines[] = "    \$schema = get_database_schema('app_db');";
        $lines[] = "    \$expectedTables = ['users', 'posts', 'settings']; // Adjust as needed";
        $lines[] = "    foreach (\$expectedTables as \$table) {";
        $lines[] = "        \$this->assertContains(\$table, \$schema['tables'], \"Table '\$table' should exist in 'app_db'.\");";
        $lines[] = "    }";
    } elseif (stripos($desc, 'accessible') !== false) {
        $lines[] = "    \$result = test_app_db_query();";
        $lines[] = "    \$this->assertTrue(\$result['success'], \"Application should be able to access the database.\");";
    } else {
        $lines[] = "    // TODO: Implement test logic for this scenario.";
    }
    return implode("\n", $lines);
}