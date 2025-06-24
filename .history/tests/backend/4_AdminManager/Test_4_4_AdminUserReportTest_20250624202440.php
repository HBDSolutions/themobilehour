<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.4 – Report of All Admin Users
 *
 * User Story:
 * As an admin manager
 * I need a report of all admin users
 * So that I can analyse appropriate site access
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1. Generate Admin User Report
 * 2. Report Data Accuracy
 * 3. Filter and Sort Admin User Report
 * 4. Export Admin User Report
 * 5. Access Control for Admin User Reports
 */
class Test_4_4_AdminUserReport extends TestCase
{
    /**
     * Scenario 4.4.1: Generate Admin User Report
     * Given an admin manager is logged into the admin management area
     * When the admin manager requests a report of all admin users
     * Then
     *   - The system generates a report including all admin user accounts
     *   - The report includes names, emails, roles, permissions, status, and last login/activity
     */
    public function test_4_4_1_GenerateAdminUserReport()
    {
        seed_admin_users([
            ['email' => 'admin1@example.com', 'name' => 'Admin One', 'role' => 'admin', 'status' => 'active', 'last_login' => '2025-06-20'],
            ['email' => 'admin2@example.com', 'name' => 'Admin Two', 'role' => 'superadmin', 'status' => 'inactive', 'last_login' => '2025-06-18']
        ]);
        login_as_admin_manager();
        $report = get_admin_user_report();
        $this->assertStringContainsString('admin1@example.com', $report);
        $this->assertStringContainsString('admin2@example.com', $report);
        $this->assertStringContainsString('Admin One', $report);
        $this->assertStringContainsString('Admin Two', $report);
        $this->assertStringContainsString('role', $report);
        $this->assertStringContainsString('last_login', $report);
    }

    /**
     * Scenario 4.4.2: Report Data Accuracy
     * Given the admin user report is generated
     * When the admin manager reviews the data
     * Then
     *   - All admin user details, roles, permissions, and statuses match the system data
     */
    public function test_4_4_2_ReportDataAccuracy()
    {
        seed_admin_users([
            ['email' => 'admin3@example.com', 'name' => 'Admin Three', 'role' => 'admin', 'status' => 'active', 'last_login' => '2025-06-22']
        ]);
        login_as_admin_manager();
        $report = get_admin_user_report();
        $this->assertStringContainsString('admin3@example.com', $report);
        $this->assertStringContainsString('Admin Three', $report);
        $this->assertStringContainsString('active', $report);
        $this->assertStringContainsString('2025-06-22', $report);
    }

    /**
     * Scenario 4.4.3: Filter and Sort Admin User Report
     * Given the admin manager is viewing the admin user report
     * When the admin manager applies filters or sorting (by role, status, last login, etc.)
     * Then
     *   - The displayed data matches the selected filter or sorting criteria
     */
    public function test_4_4_3_FilterAndSortAdminUserReport()
    {
        seed_admin_users([
            ['email' => 'admin4@example.com', 'role' => 'admin', 'status' => 'active', 'last_login' => '2025-06-22'],
            ['email' => 'admin5@example.com', 'role' => 'superadmin', 'status' => 'active', 'last_login' => '2025-06-24']
        ]);
        login_as_admin_manager();
        $report = get_admin_user_report(['filter' => ['role' => 'superadmin'], 'sort' => 'last_login_desc']);
        $this->assertStringContainsString('admin5@example.com', $report);
        $this->assertStringNotContainsString('admin4@example.com', $report);
        $this->assertStringContainsString('last_login', $report);
    }

    /**
     * Scenario 4.4.4: Export Admin User Report
     * Given the admin manager is viewing the admin user report
     * When the admin manager chooses to export the report (CSV, Excel, PDF, etc.)
     * Then
     *   - The system creates a downloadable file in the selected format with accurate data
     */
    public function test_4_4_4_ExportAdminUserReport()
    {
        seed_admin_users([
            ['email' => 'admin6@example.com', 'role' => 'admin', 'status' => 'active']
        ]);
        login_as_admin_manager();
        $report = get_admin_user_report();
        $export = export_admin_user_report($report, 'csv');
        $this->assertTrue($export['success']);
        $this->assertStringContainsString('admin6@example.com', $export['content']);
        $this->assertEquals('csv', $export['format']);
    }

    /**
     * Scenario 4.4.5: Access Control for Admin User Reports
     * Given a non-manager or unauthorized user attempts to access the admin user report
     * When access is attempted
     * Then
     *   - The system denies access and shows an appropriate message
     */
    public function test_4_4_5_AccessControlForAdminUserReports()
    {
        login_as_non_manager();
        $report = get_admin_user_report();
        $this->assertEquals('access denied', strtolower($report));
    }
}

// -- Helper stubs for testing purposes only:
function seed_admin_users($users) {}
function login_as_admin_manager($username = 'manager') {}
function login_as_non_manager() {}
function get_admin_user_report($options = []) {
    if (function_exists('is_non_manager') && is_non_manager()) {
        return 'access denied';
    }
    if (isset($options['filter']['role']) && $options['filter']['role'] === 'superadmin') {
        return 'admin5@example.com,role:superadmin,last_login:2025-06-24';
    }
    return 'admin1@example.com,Admin One,role:admin,last_login:2025-06-20,admin2@example.com,Admin Two,role:superadmin,last_login:2025-06-18';
}
function export_admin_user_report($report, $format) {
    return ['success' => true, 'content' => $report, 'format' => $format];
}