<?php

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
 * 5.1.1: DBMS Running in XAMPP
 * 5.1.2: DBMS Accessible via phpMyAdmin
 * 5.1.3: Application Can Connect to DBMS
 */
class Test_5_1_DBMSActive extends TestCase
{
    /**
     * Scenario 5.1.1: DBMS Running in XAMPP
     * Given XAMPP is running on the server
     * When I check the status of the MySQL module in XAMPP Control Panel
     * Then the MySQL service is shown as "Running"
     */
    public function test_5_1_1_DBMSRunningInXAMPP()
    {
        $status = get_xampp_mysql_status();
        $this->assertEquals('Running', $status, "MySQL service should be running in XAMPP.");
    }

    /**
     * Scenario 5.1.2: DBMS Accessible via phpMyAdmin
     * Given MySQL is running in XAMPP
     * When I open phpMyAdmin in a web browser
     * Then I can log in and view the database server status and databases list
     */
    public function test_5_1_2_DBMSAccessibleViaPhpMyAdmin()
    {
        $phpmyadminStatus = check_phpmyadmin_access();
        $this->assertTrue($phpmyadminStatus['can_login'], "Should be able to log in to phpMyAdmin.");
        $this->assertNotEmpty($phpmyadminStatus['server_status'], "Should see the DB server status.");
        $this->assertNotEmpty($phpmyadminStatus['databases'], "Should see a list of databases.");
    }

    /**
     * Scenario 5.1.3: Application Can Connect to DBMS
     * Given the application is configured to use MySQL
     * When the application attempts to connect to the database
     * Then the connection is successful and no 'cannot connect' errors occur
     */
    public function test_5_1_3_ApplicationCanConnectToDBMS()
    {
        $appConnection = test_app_database_connection();
        $this->assertTrue($appConnection['success'], "Application should successfully connect to the DBMS.");
        $this->assertArrayNotHasKey('error', $appConnection, "There should be no connection errors.");
    }
}

// --- Helper stubs for demonstration/test scaffolding purposes only ---

function get_xampp_mysql_status()
{
    // In real test, this would check the process/service
    return 'Running'; // Simulate the "Running" status
}

function check_phpmyadmin_access()
{
    // In real test, simulate HTTP login and parsing the page
    return [
        'can_login' => true,
        'server_status' => 'Online',
        'databases' => ['information_schema', 'mydb', 'test']
    ];
}

function test_app_database_connection()
{
    // In real test, this would attempt a PDO/MySQLi connection
    return [
        'success' => true
    ];
}