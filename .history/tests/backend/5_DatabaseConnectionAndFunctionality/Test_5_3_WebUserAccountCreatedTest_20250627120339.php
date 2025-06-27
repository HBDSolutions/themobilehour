<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.3 – Web Connection User Account Creation
 *
 * User Story:
 * As a system administrator
 * I need a dedicated user account for the web application to connect to the database
 * So that I can securely manage application access to the DBMS
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.3.1 – Web Application User Account Exists
 * 5.3.2 – Web User Account Has Application-Appropriate Privileges
 * 5.3.3 – Application Can Connect Using Web User Account
 */
class Test_5_3_WebUserAccountCreatedTest extends TestCase
{
    /**
     * 5.3.1 – Web Application User Account Exists
     * Given the database server is running
     * When I check the list of MySQL users
     * Then there is a user account specifically for the web application (e.g., 'webapp_user')
     */
    public function test_5_3_1_WebApplicationUserAccountExists()
    {
        $adminUser = 'root';
        $adminPass = 'your_root_password';
        $host = 'localhost';
        $webAppUser = 'webapp_user'; // Change if your application's user is named differently

        $pdo = new PDO("mysql:host=$host", $adminUser, $adminPass);

        // MySQL 5.7+ users table
        $stmt = $pdo->query("SELECT User FROM mysql.user WHERE User = '$webAppUser'");
        $userExists = $stmt->fetchColumn();

        $this->assertEquals($webAppUser, $userExists, "Web application user account '$webAppUser' should exist in MySQL.");
    }

    /**
     * 5.3.2 – Web User Account Has Application-Appropriate Privileges
     * Given the web application user account exists
     * When I review the privileges assigned to the user
     * Then the user has only the minimum necessary privileges to read/write data as required by the application
     */
    public function test_5_3_2_WebUserAccountHasAppPrivileges()
    {
        $adminUser = 'root';
        $adminPass = 'your_root_password';
        $host = 'localhost';
        $webAppUser = 'webapp_user';
        $webAppHost = 'localhost'; // Adjust if your user is defined with a different host
        $expectedPrivileges = ['SELECT', 'INSERT', 'UPDATE', 'DELETE']; // Minimal necessary privileges

        $pdo = new PDO("mysql:host=$host", $adminUser, $adminPass);

        // Get grants for the webapp_user
        $stmt = $pdo->query("SHOW GRANTS FOR '$webAppUser'@'$webAppHost'");
        $grants = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $grantString = implode(' ', $grants);

        foreach ($expectedPrivileges as $priv) {
            $this->assertStringContainsString(
                $priv,
                $grantString,
                "Web application user should have $priv privilege."
            );
        }

        // Optionally, assert that user does NOT have dangerous privileges
        $dangerous = ['DROP', 'GRANT', 'ALTER', 'CREATE USER', 'FILE'];
        foreach ($dangerous as $priv) {
            $this->assertStringNotContainsString(
                $priv,
                $grantString,
                "Web application user should NOT have $priv privilege."
            );
        }
    }

    /**
     * 5.3.3 – Application Can Connect Using Web User Account
     * Given the web application is configured to use the web user account
     * When the application attempts to connect to the database
     * Then the connection is successful using the web user account credentials
     */
    public function test_5_3_3_ApplicationCanConnectWithWebUser()
    {
        $webAppUser = 'webapp_user';
        $webAppPass = 'webapp_password'; // Set to your web app user's password
        $host = 'localhost';
        $db = 'your_app_db'; // Set to your application's database name

        $dsn = "mysql:host=$host;dbname=$db";
        try {
            $pdo = new PDO($dsn, $webAppUser, $webAppPass);
            $this->assertTrue(true, "Web application user account was able to connect to the database.");
        } catch (\PDOException $e) {
            $this->fail("Web application user could not connect: " . $e->getMessage());
        }
    }
}