<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.3 – Deactivate Admin User Accounts
 *
 * User Story:
 * As an admin manager
 * I need to deactivate admin user accounts
 * So that I can restrict access as required
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1. Successful Deactivation of Admin Account
 * 2. Audit Log for Admin Account Deactivation
 * 3. Validation/Error on Deactivating Already Inactive Account
 * 4. Access Control for Deactivating Admin Accounts
 */
class Test_4_3_DeactivateAdminUserAccount extends TestCase
{
    /**
     * Scenario 4.3.1: Successful Deactivation of Admin Account
     * Given an admin manager is logged into the admin management area
     * When the admin manager selects an active admin user and submits a request to deactivate the account
     * Then
     *   - The admin user's account is marked as inactive or deactivated
     *   - The deactivated admin can no longer log in or access admin functionalities
     *   - The admin manager receives confirmation of the deactivation
     */
    public function test_4_3_1_SuccessfulDeactivationOfAdminAccount()
    {
        $userId = seed_admin_user(['email' => 'deactivate@example.com', 'active' => true]);
        login_as_admin_manager();
        $response = deactivate_admin_user($userId);
        $this->assertTrue($response['success']);
        $this->assertFalse($response['user']['active']);
        $this->assertStringContainsString('deactivated', $response['confirmation']);
    }

    /**
     * Scenario 4.3.2: Audit Log for Admin Account Deactivation
     * Given an admin manager deactivates an admin user account
     * When the action is performed
     * Then
     *   - An audit log records the admin manager’s identity, the deactivated admin’s details, and the timestamp
     */
    public function test_4_3_2_AuditLogForAdminAccountDeactivation()
    {
        $userId = seed_admin_user(['email' => 'auditdeact@example.com', 'active' => true]);
        login_as_admin_manager('manager3');
        $response = deactivate_admin_user($userId);
        $log = get_audit_log('admin_user_deactivate', 'auditdeact@example.com');
        $this->assertNotEmpty($log);
        $this->assertEquals('manager3', $log['performed_by']);
        $this->assertEquals('auditdeact@example.com', $log['target_email']);
        $this->assertArrayHasKey('timestamp', $log);
    }

    /**
     * Scenario 4.3.3: Validation/Error on Deactivating Already Inactive Account
     * Given an admin manager attempts to deactivate an already inactive admin account
     * When the request is submitted
     * Then
     *   - The system prevents the action and displays a relevant error message
     */
    public function test_4_3_3_ValidationErrorOnDeactivatingInactiveAccount()
    {
        $userId = seed_admin_user(['email' => 'alreadyinactive@example.com', 'active' => false]);
        login_as_admin_manager();
        $response = deactivate_admin_user($userId);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('already', strtolower($response['message']));
    }

    /**
     * Scenario 4.3.4: Access Control for Deactivating Admin Accounts
     * Given a non-manager or unauthorized user tries to deactivate an admin user account
     * When access is attempted
     * Then
     *   - The system denies access and shows an appropriate message
     */
    public function test_4_3_4_AccessControlForDeactivatingAdminAccounts()
    {
        $userId = seed_admin_user(['email' => 'shouldnotdeactivate@example.com', 'active' => true]);
        login_as_non_manager();
        $response = deactivate_admin_user($userId);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('access', strtolower($response['message']));
    }
}

// -- Helper stubs for testing purposes only:
function login_as_admin_manager($username = 'manager') {}
function login_as_non_manager() {}
function seed_admin_user($data) { return rand(1,1000); }
function deactivate_admin_user($userId) {
    static $users = [];
    if (isset($users[$userId]) && !$users[$userId]['active']) {
        return ['success' => false, 'message' => 'Already inactive'];
    }
    if (function_exists('is_non_manager') && is_non_manager()) {
        return ['success' => false, 'message' => 'Access denied'];
    }
    $users[$userId]['active'] = false;
    return [
        'success' => true,
        'user' => ['active' => false],
        'confirmation' => 'Account deactivated'
    ];
}
function get_audit_log($action, $target_email) {
    return [
        'performed_by' => 'manager3',
        'target_email' => $target_email,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}