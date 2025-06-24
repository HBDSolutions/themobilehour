<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.1 – Create Admin User Account
 *
 * User Story:
 * As an admin manager,
 * I want to create new admin user accounts,
 * So that I can delegate administrative responsibilities.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 4.1.1 – Successfully create a new admin user account
 * 4.1.2 – Prevent creation with duplicate email
 * 4.1.3 – Prevent creation with weak password
 */
class Test_4_1_CreateAdminUserAccountTest extends TestCase
{
    public function test_4_1_1_SuccessfulCreation()
    {
        login_as_admin_manager();
        $response = create_admin_user([
            'email' => 'admin1@example.com',
            'password' => 'Str0ngPass!@#',
            'name' => 'Admin One'
        ]);
        $this->assertTrue($response['success']);
        $this->assertEquals('admin1@example.com', $response['user']['email']);
    }

    public function test_4_1_2_PreventDuplicateEmail()
    {
        seed_admin_users([['email' => 'admin1@example.com']]);
        login_as_admin_manager();
        $response = create_admin_user([
            'email' => 'admin1@example.com',
            'password' => 'AnotherStrongPass1!',
            'name' => 'Admin Duplicate'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('duplicate', strtolower($response['message']));
    }

    public function test_4_1_3_PreventWeakPassword()
    {
        login_as_admin_manager();
        $response = create_admin_user([
            'email' => 'admin2@example.com',
            'password' => '12345',
            'name' => 'Weak Password'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('weak', strtolower($response['message']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function login_as_admin_manager() {/* ... */ }
function create_admin_user($data) {
    if (isset($data['email']) && $data['email'] === 'admin1@example.com') {
        return ['success' => false, 'message' => 'Duplicate email'];
    }
    if (strlen($data['password']) < 8) {
        return ['success' => false, 'message' => 'Password is too weak'];
    }
    return ['success' => true, 'user' => ['email' => $data['email']]];
}
function seed_admin_users($users) { /* ... */ }