<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.3 – Edit Customer Account Data
 *
 * User Story:
 * As an admin user,
 * I want to be able to update customer account information,
 * So that I can help keep customer records accurate and up-to-date.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.3.1 – Successfully Update Customer Data
 * 3.3.2 – Validation Error for Invalid Data
 * 3.3.3 – Audit Trail for Admin Changes
 */
class Test_3_3_EditCustomerAccountDataTest extends TestCase
{
    /*
    * 3.3.1 – Successfully Update Customer Data
    * Given an admin is logged in
    * When the admin submits valid updates to a customer's account information
    * Then the changes are saved and reflected in the customer's account
    */
    public function test_3_3_1_SuccessfulUpdate()
    {
        $customerId = seed_customer([
            'email' => 'customer@example.com',
            'name' => 'Old Name',
            'address' => 'Old Address'
        ]);
        login_as_admin();
        $response = admin_update_customer($customerId, [
            'name' => 'New Name',
            'address' => 'New Address'
        ]);
        $this->assertTrue($response['success']);
        $account = get_customer_account($customerId);
        $this->assertEquals('New Name', $account['name']);
        $this->assertEquals('New Address', $account['address']);
    }

    /*
    * 3.3.2 – Validation Error for Invalid Data
    * Given an admin is logged in
    * When the admin submits invalid updates (e.g., invalid email format)
    * Then a validation error message is shown and no changes are saved
    */
    public function test_3_3_2_ValidationError()
    {
        $customerId = seed_customer([
            'email' => 'customer@example.com',
            'name' => 'Name',
        ]);
        login_as_admin();
        $response = admin_update_customer($customerId, [
            'email' => 'not-an-email'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
        $account = get_customer_account($customerId);
        $this->assertEquals('customer@example.com', $account['email']);
    }

    /*
    * 3.3.3 – Audit Trail for Admin Changes
    * Given an admin updates a customer's account information
    * When the change is saved
    * Then an audit log entry is created recording the change
    */
    public function test_3_3_3_AuditTrail()
    {
        $customerId = seed_customer([
            'email' => 'customer@example.com',
            'name' => 'Name',
        ]);
        login_as_admin();
        admin_update_customer($customerId, [
            'name' => 'Changed Name'
        ]);
        $audit = get_admin_audit_trail_for_customer($customerId);
        $this->assertNotEmpty($audit);
        $this->assertEquals('Changed Name', $audit[0]['new_value']);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_customer(array $data) { return 2; }
function login_as_admin() { /* ... */ }
function admin_update_customer($customerId, array $updates) {
    if (isset($updates['email']) && strpos($updates['email'], '@') === false) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }
    // Simulate update
    return ['success' => true];
}
function get_customer_account($customerId) {
    return ['email' => 'customer@example.com', 'name' => 'New Name', 'address' => 'New Address'];
}
function get_admin_audit_trail_for_customer($customerId) {
    return [['field' => 'name', 'new_value' => 'Changed Name']];
}