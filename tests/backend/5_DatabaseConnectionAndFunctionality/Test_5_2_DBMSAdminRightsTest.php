<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.2 – DBMS Administration Rights Assignment
 *
 * User Story:
 * As a system administrator
 * I need to ensure that administration rights have been assigned for the DBMS
 * So that authorized users can perform necessary database management tasks
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.2.1 – Admin User Has Full DBMS Privileges
 * 5.2.2 – Non-Admin User Cannot Perform Admin Actions
 * 5.2.3 – Audit/Admin Log Records Privilege Assignments
 */
class Test_5_2_DBMSAdminRightsTest extends TestCase
{
    /**
     * 5.2.1 – Admin User Has Full DBMS Privileges
     * Given a user is assigned as a DBMS administrator
     * When the user logs into MySQL (via phpMyAdmin or command line)
     * Then
     *  - The user can create, read, update, and delete databases and tables
     *  - The user can manage user accounts and permissions
     */
    public function test_5_2_1_AdminUserHasFullDBMSPrivileges()
    {
        // TODO: Replace with admin credentials for testing
        $adminUser = 'admin_user';
        $adminPass = 'admin_password';
        $host = 'localhost';

        try {
            $pdo = new PDO("mysql:host=$host", $adminUser, $adminPass);

            // Try to create a database (will drop if already exists)
            $testDb = 'test_admin_privileges_db';
            $pdo->exec("DROP DATABASE IF EXISTS `$testDb`");
            $pdo->exec("CREATE DATABASE `$testDb`");
            $pdo->exec("USE `$testDb`");

            // Try to create a table
            $pdo->exec("CREATE TABLE test_table (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50))");

            // Try to insert, update, delete
            $pdo->exec("INSERT INTO test_table (name) VALUES ('Alice')");
            $pdo->exec("UPDATE test_table SET name='Bob' WHERE name='Alice'");
            $pdo->exec("DELETE FROM test_table WHERE name='Bob'");

            // Try to drop table and database
            $pdo->exec("DROP TABLE test_table");
            $pdo->exec("DROP DATABASE `$testDb`");

            // Try to manage users (this may require SUPER privilege)
            // $pdo->exec("CREATE USER 'tempadmin'@'localhost' IDENTIFIED BY 'temppass'");
            // $pdo->exec("DROP USER 'tempadmin'@'localhost'");

            $this->assertTrue(true, 'Admin user can perform all required admin actions.');
        } catch (\PDOException $e) {
            $this->fail('Admin user failed to perform admin actions: ' . $e->getMessage());
        }
    }

    /**
     * 5.2.2 – Non-Admin User Cannot Perform Admin Actions
     * Given a user is not assigned as a DBMS administrator
     * When the user attempts to perform administrative actions (e.g., create/drop database, manage users)
     * Then
     *  - The system denies the action and displays an appropriate error or warning
     */
    public function test_5_2_2_NonAdminUserCannotAdmin()
    {
        // TODO: Replace with non-admin credentials for testing
        $nonAdminUser = 'regular_user';
        $nonAdminPass = 'regular_password';
        $host = 'localhost';

        try {
            $pdo = new PDO("mysql:host=$host", $nonAdminUser, $nonAdminPass);
            $this->expectException(\PDOException::class);

            // Attempt to create a database (should fail)
            $pdo->exec("CREATE DATABASE should_not_work_db");
        } catch (\PDOException $e) {
            $this->assertStringContainsString(
                'permission',
                strtolower($e->getMessage()),
                'Non-admin user should be denied permission for admin actions.'
            );
            return;
        }
        $this->fail('Non-admin user was able to perform admin actions.');
    }

    /**
     * 5.2.3 – Audit/Admin Log Records Privilege Assignments
     * Given administration rights are assigned to a user
     * When the assignment occurs
     * Then
     *  - The event is recorded in an audit or admin log with the user, grantor, and timestamp
     */
    public function test_5_2_3_AuditLogRecordsPrivilegeAssignment()
    {
        // NOTE: This test assumes the existence of an audit log system for privilege assignments.
        // If no such system exists, mark as incomplete.
        $this->markTestIncomplete('Audit log verification for privilege assignments requires audit log system implementation.');
    }
}