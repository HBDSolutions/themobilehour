<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.1 – DBMS Active Check
 *
 * User Story:
 * As a system administrator
 * I need to verify that the DBMS (MySQL) is active via phpMyAdmin and XAMPP
 * So that I can ensure the database is available for application use
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.1.1 – DBMS Running in XAMPP
 * 5.1.2 – DBMS Accessible via phpMyAdmin
 * 5.1.3 – Application Can Connect to DBMS
 */
class Test_5_1_DBMSActiveTest extends TestCase
{
    /*
    * 5.1.1 – DBMS Running in XAMPP
    * Given XAMPP is running on the server
    * When I check the status of the MySQL module in XAMPP Control Panel
    * Then
    * - the MySQL service is shown as "Running"
    */
    public function test_5_1_1_DBMSRunningInXAMPP()
    {
        // TODO: Implement test logic for this scenario.
        // This test may require a manual or integration check that XAMPP's MySQL service is running.
    }

    /*
    * 5.1.2 – DBMS Accessible via phpMyAdmin
    * Given MySQL is running in XAMPP
    * When I open phpMyAdmin in a web browser
    * Then
    * - I can log in and view the database server status and databases list
    */
    public function test_5_1_2_DBMSAccessibleViaPhpMyAdmin()
    {
        // TODO: Implement test logic for this scenario.
        // This might involve checking HTTP status or automating browser login to phpMyAdmin.
    }

    /*
    * 5.1.3 – Application Can Connect to DBMS
    * Given the application is configured to use MySQL
    * When the application attempts to connect to the database
    * Then
    * - the connection is successful and no "cannot connect" errors occur
    */
    public function test_5_1_3_ApplicationCanConnectToDBMS()
    {
        // Example implementation using PDO:
        $host = 'localhost';
        $db   = 'your_db_name';
        $user = 'your_db_user';
        $pass = 'your_db_password';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $this->assertTrue(true, 'Database connection successful.');
        } catch (\PDOException $e) {
            $this->fail('Database connection failed: ' . $e->getMessage());
        }
    }
}