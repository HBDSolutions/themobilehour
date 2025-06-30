<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.4 – Database Creation/Import and Availability
 *
 * User Story:
 * As a system administrator
 * I need to ensure that the application database has been created or imported and is available
 * So that the application can reliably store and retrieve data
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.4.1 – Database Exists
 * 5.4.2 – Database Schema is Present
 * 5.4.3 – Database is Accessible
 */
class Test_5_4_DatabaseCreatedAndAvailableTest extends TestCase
{
    /**
     * 5.4.1 – Database Exists
     * Given MySQL is running
     * When I check the list of databases
     * Then the application database (e.g., `app_db`) is present
     */
    public function test_5_4_1_DatabaseExists()
    {
        $host = 'localhost';
        $user = 'your_db_user';
        $pass = 'your_db_password';
        $expectedDb = 'app_db'; // Replace with your actual database name

        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $databases = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);

        $this->assertContains($expectedDb, $databases, "Database `$expectedDb` should exist");
    }

    /**
     * 5.4.2 – Database Schema is Present
     * Given the application database exists
     * When I inspect its tables
     * Then all required tables and columns (according to the application schema) are present
     */
    public function test_5_4_2_DatabaseSchemaIsPresent()
    {
        // Define your expected tables and columns here:
        $expected = [
            'users' => ['id', 'username', 'password', 'email'],
            'posts' => ['id', 'user_id', 'title', 'content'],
            // Add more tables/columns as required by your application
        ];

        $host = 'localhost';
        $db   = 'app_db'; // Replace with your actual database name
        $user = 'your_db_user';
        $pass = 'your_db_password';

        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        foreach ($expected as $table => $columns) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            $this->assertNotFalse($stmt->fetch(), "Table `$table` should exist");
            $stmt = $pdo->query("DESCRIBE `$table`");
            $actualColumns = array_column($stmt->fetchAll(), 'Field');
            foreach ($columns as $col) {
                $this->assertContains($col, $actualColumns, "Column `$col` should exist in `$table`");
            }
        }
    }

    /**
     * 5.4.3 – Database is Accessible
     * Given the application is configured to connect to the database
     * When the application attempts to query the database
     * Then queries succeed and no access errors occur
     */
    public function test_5_4_3_DatabaseIsAccessible()
    {
        $host = 'localhost';
        $db   = 'app_db'; // Replace with your actual database name
        $user = 'your_db_user';
        $pass = 'your_db_password';

        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $stmt = $pdo->query("SELECT 1");
        $this->assertEquals(1, $stmt->fetchColumn());
    }
}