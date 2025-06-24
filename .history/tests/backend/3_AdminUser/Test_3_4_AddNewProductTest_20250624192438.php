<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.4 – Add New Product
 *
 * User Story:
 * As an admin user,
 * I want to add new products to the catalogue,
 * So that I can keep the product range up to date for customers.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.4.1 – Successfully Add New Product
 * 3.4.2 – Validation Error for Invalid Product Data
 * 3.4.3 – Product Appears in Catalogue After Addition
 */
class Test_3_4_AddNewProductTest extends TestCase
{
    /*
    * 3.4.1 – Successfully Add New Product
    * Given an admin is logged in
    * When the admin submits valid product information
    * Then the new product is added to the catalogue and visible to customers
    */
    public function test_3_4_1_SuccessfulAdd()
    {
        login_as_admin();
        $productData = [
            'name' => 'SuperPhone X',
            'brand' => 'SuperBrand',
            'price' => 699.99
        ];
        $response = admin_add_product($productData);
        $this->assertTrue($response['success']);
        $catalogue = get_products_browse_page();
        $this->assertStringContainsString('SuperPhone X', $catalogue);
    }

    /*
    * 3.4.2 – Validation Error for Invalid Product Data
    * Given an admin is logged in
    * When the admin submits invalid product information (e.g., missing name)
    * Then a validation error message is shown and the product is not added
    */
    public function test_3_4_2_ValidationError()
    {
        login_as_admin();
        $productData = [
            'name' => '',
            'brand' => 'SuperBrand',
            'price' => 699.99
        ];
        $response = admin_add_product($productData);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 3.4.3 – Product Appears in Catalogue After Addition
    * Given an admin adds a new product
    * When customers browse the catalogue
    * Then the new product is displayed in the product list
    */
    public function test_3_4_3_ProductAppearsInCatalogue()
    {
        login_as_admin();
        $productData = [
            'name' => 'MegaPhone Y',
            'brand' => 'MegaBrand',
            'price' => 899.99
        ];
        admin_add_product($productData);
        $catalogue = get_products_browse_page();
        $this->assertStringContainsString('MegaPhone Y', $catalogue);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function login_as_admin() { /* ... */ }
function admin_add_product($productData) {
    if (empty($productData['name'])) {
        return ['success' => false, 'message' => 'Invalid product data'];
    }
    return ['success' => true];
}
function get_products_browse_page() {
    return 'SuperPhone X MegaPhone Y';
}