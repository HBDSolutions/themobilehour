<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.6 – Delete Product
 *
 * User Story:
 * As an admin user,
 * I want to be able to remove obsolete or incorrect products from the catalogue,
 * So that customers only see current and valid products.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.6.1 – Successfully Delete Product
 * 3.6.2 – Prevent Deletion of Non-Existent Product
 * 3.6.3 – Product No Longer Visible to Customers
 */
class Test_3_6_DeleteProductTest extends TestCase
{
    /*
    * 3.6.1 – Successfully Delete Product
    * Given an admin is logged in
    * When the admin deletes an existing product
    * Then the product is removed from the catalogue
    */
    public function test_3_6_1_SuccessfulDelete()
    {
        $productId = seed_product(['name' => 'OldProduct']);
        login_as_admin();
        $response = admin_delete_product($productId);
        $this->assertTrue($response['success']);
        $catalogue = get_products_browse_page();
        $this->assertStringNotContainsString('OldProduct', $catalogue);
    }

    /*
    * 3.6.2 – Prevent Deletion of Non-Existent Product
    * Given an admin is logged in
    * When the admin tries to delete a product that does not exist
    * Then an error message is shown
    */
    public function test_3_6_2_PreventDeletionOfNonExistentProduct()
    {
        login_as_admin();
        $response = admin_delete_product(999); // Non-existent
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('not found', strtolower($response['message']));
    }

    /*
    * 3.6.3 – Product No Longer Visible to Customers
    * Given an admin deletes a product
    * When customers browse the catalogue
    * Then the deleted product is not displayed in the product list
    */
    public function test_3_6_3_ProductNoLongerVisible()
    {
        $productId = seed_product(['name' => 'ToDelete']);
        login_as_admin();
        admin_delete_product($productId);
        $catalogue = get_products_browse_page();
        $this->assertStringNotContainsString('ToDelete', $catalogue);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_product(array $data) { return rand(1, 1000); }
function login_as_admin() { /* ... */ }
function admin_delete_product($productId) {
    if ($productId === 999) {
        return ['success' => false, 'message' => 'Product not found'];
    }
    return ['success' => true];
}
function get_products_browse_page() {
    return '';
}