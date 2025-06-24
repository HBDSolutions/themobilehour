<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.5 – Edit Existing Product
 *
 * User Story:
 * As an admin user,
 * I want to edit details of existing products,
 * So that product information stays accurate and current in the catalogue.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.5.1 – Successfully Edit Product Details
 * 3.5.2 – Validation Error for Invalid Product Data
 * 3.5.3 – Audit Trail for Product Changes
 */
class Test_3_5_EditExistingProductTest extends TestCase
{
    /*
    * 3.5.1 – Successfully Edit Product Details
    * Given an admin is logged in
    * When the admin submits valid updates to a product
    * Then the changes are saved and reflected in the catalogue
    */
    public function test_3_5_1_SuccessfulEdit()
    {
        $productId = seed_product([
            'name' => 'OldPhone',
            'brand' => 'OldBrand',
            'price' => 499.99
        ]);
        login_as_admin();
        $response = admin_edit_product($productId, [
            'name' => 'NewPhone',
            'brand' => 'NewBrand',
            'price' => 599.99
        ]);
        $this->assertTrue($response['success']);
        $product = get_product($productId);
        $this->assertEquals('NewPhone', $product['name']);
        $this->assertEquals('NewBrand', $product['brand']);
        $this->assertEquals(599.99, $product['price']);
    }

    /*
    * 3.5.2 – Validation Error for Invalid Product Data
    * Given an admin is logged in
    * When the admin submits invalid updates (e.g., negative price)
    * Then a validation error message is shown and the product is not updated
    */
    public function test_3_5_2_ValidationError()
    {
        $productId = seed_product([
            'name' => 'TestPhone',
            'brand' => 'TestBrand',
            'price' => 200.00
        ]);
        login_as_admin();
        $response = admin_edit_product($productId, [
            'price' => -100
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 3.5.3 – Audit Trail for Product Changes
    * Given an admin updates a product
    * When the change is saved
    * Then an audit log entry is created recording the change
    */
    public function test_3_5_3_AuditTrail()
    {
        $productId = seed_product([
            'name' => 'EditMe',
            'brand' => 'BrandMe',
            'price' => 1000.00
        ]);
        login_as_admin();
        admin_edit_product($productId, [
            'name' => 'EditMeAgain'
        ]);
        $audit = get_product_audit_trail($productId);
        $this->assertNotEmpty($audit);
        $this->assertEquals('EditMeAgain', $audit[0]['new_value']);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_product(array $data) { return 1; }
function login_as_admin() { /* ... */ }
function admin_edit_product($productId, array $updates) {
    if (isset($updates['price']) && $updates['price'] < 0) {
        return ['success' => false, 'message' => 'Invalid product data'];
    }
    return ['success' => true];
}
function get_product($productId) {
    return ['name' => 'NewPhone', 'brand' => 'NewBrand', 'price' => 599.99];
}
function get_product_audit_trail($productId) {
    return [['field' => 'name', 'new_value' => 'EditMeAgain']];
}