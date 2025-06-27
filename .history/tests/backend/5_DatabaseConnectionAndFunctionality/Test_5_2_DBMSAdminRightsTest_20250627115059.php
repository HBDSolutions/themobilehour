<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.2 – Database Exists
 *
 * User Story:
 * As a system administrator
 * I need to ensure the application database exists in MySQL
 * So that the application can store and retrieve data
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.2.1 – Database is Present
 */
class Test_5_2_DatabaseExistsTest extends TestCase
{
    /*
    * 5.2.1 – Database is Present
    * Given MySQL is running
    * When I check the list of databases
    * Then
    * - the application database (e.g., `app_db`) is present
    */
    public function test_5_2_1_DatabaseIsPresent()
    {
        $host = 'localhost';
        $user = 'your_db_user';
        $pass = 'your_db_password';
        $expectedDb = 'app_db';

        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $databases = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);

        $this->assertContains($expectedDb, $databases, "Database `$expectedDb` should exist");
    }
}