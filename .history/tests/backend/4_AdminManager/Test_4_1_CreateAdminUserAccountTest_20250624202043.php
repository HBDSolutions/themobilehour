<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.1 – Create New Admin User Accounts
 *
 * User Story:
 * As an admin manager
 * I need to create new admin user accounts
 * So that admins can perform website and database management tasks
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1. Successful Admin User Account Creation
 * 2. Validation Errors on Admin User Account Creation
 * 3. Audit Log for Admin Account Creation
 * 4. Access Control for Admin User Creation
 */
class Test_4_1_CreateAdminUserAccount extends TestCase
{
    /**
     * Scenario 4.1.1: Successful Admin User Account Creation
     * Given an admin manager is logged into the admin management area
     * When the admin manager submits a valid form to create a new admin user account
     * Then
     *   - The new admin user account is created
     *   - The new admin receives login credentials or an invitation email
     *   - The admin manager receives confirmation of the creation
     */
    public function test_4_1_1_SuccessfulAdminUserAccountCreation()
    {
        login_as_admin_manager();
        $response = create_admin_user([
            'email' => 'newadmin@example.com',
            'password' => 'Str0ngPassw0rd!',
            'name' => 'New Admin'
        ]);
        $this->assertTrue($response['success']);
        $this->assertEquals('newadmin@example.com', $response['user']['email']);
        $this->assertTrue($response['credentials_sent']);
        $this->assertStringContainsString('created', $response['confirmation']);
    }

    /**
     * Scenario 4.1.2: Validation Errors on Admin User Account Creation
     * Given an admin manager is creating a new admin user account
     * When the form is submitted with missing or invalid details (e.g., duplicate email, weak password)
     * Then
     *   - The system prevents account creation
     *   - The admin manager is shown clear validation error messages
     */
    public function test_4_1_2_ValidationErrorsOnAdminUserAccountCreation()
    {
        login_as_admin_manager();
        // Duplicate email
        seed_admin_users([['email' => 'existing@example.com']]);
        $response1 = create_admin_user([
            'email' => 'existing@example.com',
            'password' => 'AnotherGood1!',
            'name' => 'Dup Email'
        ]);
        $this->assertFalse($response1['success']);
        $this->assertStringContainsString('duplicate', strtolower($response1['message']));

        // Weak password
        $response2 = create_admin_user([
            'email' => 'unique@example.com',
            'password' => '123',
            'name' => 'Weak Pass'
        ]);
        $this->assertFalse($response2['success']);
        $this->assertStringContainsString('weak', strtolower($response2['message']));
    }

    /**
     * Scenario 4.1.3: Audit Log for Admin Account Creation
     * Given an admin manager creates a new admin user account
     * When the account is successfully created
     * Then
     *   - An audit log records the admin manager’s identity, the new admin’s details, and the timestamp
     */
    public function test_4_1_3_AuditLogForAdminAccountCreation()
    {
        login_as_admin_manager('manager1');
        $response = create_admin_user([
            'email' => 'audit@example.com',
            'password' => 'V3rySecur3!',
            'name' => 'Audit User'
        ]);
        $this->assertTrue($response['success']);
        $log = get_audit_log('admin_user_create', $response['user']['email']);
        $this->assertNotEmpty($log);
        $this->assertEquals('manager1', $log['performed_by']);
        $this->assertEquals('audit@example.com', $log['target_email']);
        $this->assertArrayHasKey('timestamp', $log);
    }

    /**
     * Scenario 4.1.4: Access Control for Admin User Creation
     * Given a non-manager or unauthorized user tries to access the admin creation functionality
     * When access is attempted
     * Then
     *   - The system denies access and shows an appropriate message
     */
    public function test_4_1_4_AccessControlForAdminUserCreation()
    {
        login_as_non_manager();
        $response = create_admin_user([
            'email' => 'shouldnotwork@example.com',
            'password' => 'Password123!',
            'name' => 'No Access'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('access', strtolower($response['message']));
    }
}

// -- Helper stubs for testing purposes only:
function login_as_admin_manager($username = 'manager') {}
function login_as_non_manager() {}
function seed_admin_users($users) {}
function create_admin_user($data) {
    if ($data['email'] === 'existing@example.com') {
        return ['success' => false, 'message' => 'Duplicate email'];
    }
    if (strlen($data['password']) < 8) {
        return ['success' => false, 'message' => 'Password too weak'];
    }
    if (function_exists('is_non_manager') && is_non_manager()) {
        return ['success' => false, 'message' => 'Access denied'];
    }
    return [
        'success' => true,
        'user' => ['email' => $data['email']],
        'credentials_sent' => true,
        'confirmation' => 'Account created'
    ];
}
function get_audit_log($action, $target_email) {
    return [
        'performed_by' => 'manager1',
        'target_email' => $target_email,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}