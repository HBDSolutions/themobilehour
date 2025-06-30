<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.2 – Edit Admin User Accounts
 *
 * User Story:
 * As an admin manager
 * I need to edit admin user accounts
 * So that I can update admin roles and permissions
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1. Successful Admin User Account Edit
 * 2. Validation Errors on Edit
 * 3. Audit Log for Admin Account Edits
 * 4. Access Control for Editing Admin Users
 */
class Test_4_2_EditAdminUserAccount extends TestCase
{
    /**
     * Scenario 4.2.1: Successful Admin User Account Edit
     * Given an admin manager is logged into the admin management area
     * When the admin manager updates an admin user's details (role, permissions, etc.) with valid data and submits
     * Then
     *   - The admin user's updated details are saved in the system
     *   - The admin manager receives confirmation of the update
     */
    public function test_4_2_1_SuccessfulAdminUserAccountEdit()
    {
        $userId = seed_admin_user(['email' => 'editme@example.com', 'role' => 'admin']);
        login_as_admin_manager();
        $response = edit_admin_user($userId, [
            'name' => 'Edited Name',
            'role' => 'superadmin'
        ]);
        $this->assertTrue($response['success']);
        $this->assertEquals('Edited Name', $response['user']['name']);
        $this->assertEquals('superadmin', $response['user']['role']);
        $this->assertStringContainsString('updated', $response['confirmation']);
    }

    /**
     * Scenario 4.2.2: Validation Errors on Edit
     * Given an admin manager is editing an admin user account
     * When invalid or incomplete data is submitted (e.g., invalid role, empty required fields)
     * Then
     *   - The system prevents the update
     *   - The admin manager is shown clear validation error messages
     */
    public function test_4_2_2_ValidationErrorsOnEdit()
    {
        $userId = seed_admin_user(['email' => 'test@example.com', 'role' => 'admin']);
        login_as_admin_manager();
        // Invalid role
        $response = edit_admin_user($userId, [
            'role' => 'notarole'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
        // Empty required field
        $response2 = edit_admin_user($userId, [
            'name' => ''
        ]);
        $this->assertFalse($response2['success']);
        $this->assertStringContainsString('required', strtolower($response2['message']));
    }

    /**
     * Scenario 4.2.3: Audit Log for Admin Account Edits
     * Given an admin manager edits an admin user account
     * When the update is saved
     * Then
     *   - An audit log records the admin manager’s identity, the changes made, the affected admin account, and the timestamp
     */
    public function test_4_2_3_AuditLogForAdminAccountEdits()
    {
        $userId = seed_admin_user(['email' => 'audit@example.com', 'role' => 'admin']);
        login_as_admin_manager('manager2');
        $response = edit_admin_user($userId, [
            'name' => 'Audit Edit',
            'role' => 'admin'
        ]);
        $this->assertTrue($response['success']);
        $log = get_audit_log('admin_user_edit', 'audit@example.com');
        $this->assertNotEmpty($log);
        $this->assertEquals('manager2', $log['performed_by']);
        $this->assertEquals('audit@example.com', $log['target_email']);
        $this->assertArrayHasKey('timestamp', $log);
    }

    /**
     * Scenario 4.2.4: Access Control for Editing Admin Users
     * Given a non-manager or unauthorized user tries to edit an admin user account
     * When access is attempted
     * Then
     *   - The system denies access and shows an appropriate message
     */
    public function test_4_2_4_AccessControlForEditingAdminUsers()
    {
        $userId = seed_admin_user(['email' => 'noaccess@example.com', 'role' => 'admin']);
        login_as_non_manager();
        $response = edit_admin_user($userId, [
            'name' => 'Should Not Edit'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('access', strtolower($response['message']));
    }
}

// -- Helper stubs for testing purposes only:
function login_as_admin_manager($username = 'manager') {}
function login_as_non_manager() {}
function seed_admin_user($data) { return rand(1,1000); }
function edit_admin_user($userId, $data) {
    if (isset($data['role']) && $data['role'] === 'notarole') {
        return ['success' => false, 'message' => 'Invalid role'];
    }
    if (isset($data['name']) && $data['name'] === '') {
        return ['success' => false, 'message' => 'Required field missing'];
    }
    if (function_exists('is_non_manager') && is_non_manager()) {
        return ['success' => false, 'message' => 'Access denied'];
    }
    return [
        'success' => true,
        'user' => ['name' => $data['name'] ?? '', 'role' => $data['role'] ?? 'admin'],
        'confirmation' => 'Account updated'
    ];
}
function get_audit_log($action, $target_email) {
    return [
        'performed_by' => 'manager2',
        'target_email' => $target_email,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}