<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.7 – Track Stock Levels
 *
 * User Story:
 * As an admin user,
 * I want to track the stock levels of all products,
 * So that I can manage inventory and avoid stockouts or overstocking.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.7.1 – View Current Stock Levels for All Products
 * 3.7.2 – Update Stock Level for a Product
 * 3.7.3 – Receive Warning for Low Stock
 * 3.7.4 – Prevent Negative Stock Levels
 */
class Test_3_7_TrackStockLevelsTest extends TestCase
{
    public function test_3_7_1_ViewCurrentStockLevelsForAllProducts()
    {
        seed_products([
            ['id' => 1, 'name' => 'Phone X', 'stock' => 30],
            ['id' => 2, 'name' => 'Tablet Y', 'stock' => 10]
        ]);
        login_as_admin();
        $stocks = get_all_product_stock_levels();
        $this->assertArrayHasKey('Phone X', $stocks);
        $this->assertArrayHasKey('Tablet Y', $stocks);
        $this->assertEquals(30, $stocks['Phone X']);
        $this->assertEquals(10, $stocks['Tablet Y']);
    }

    public function test_3_7_2_UpdateStockLevelForAProduct()
    {
        $productId = seed_product(['name' => 'Headphones', 'stock' => 15]);
        login_as_admin();
        $response = admin_update_product_stock($productId, 25);
        $this->assertTrue($response['success']);
        $stock = get_product_stock_level($productId);
        $this->assertEquals(25, $stock);
    }

    public function test_3_7_3_ReceiveWarningForLowStock()
    {
        $productId = seed_product(['name' => 'Camera', 'stock' => 2]);
        login_as_admin();
        $response = admin_update_product_stock($productId, 1);
        $this->assertTrue($response['success']);
        $warnings = get_low_stock_warnings();
        $this->assertContains('Camera', $warnings);
    }

    public function test_3_7_4_PreventNegativeStockLevels()
    {
        $productId = seed_product(['name' => 'Speaker', 'stock' => 5]);
        login_as_admin();
        $response = admin_update_product_stock($productId, -3);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('cannot be negative', strtolower($response['message']));
        $stock = get_product_stock_level($productId);
        $this->assertGreaterThanOrEqual(0, $stock);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function seed_product(array $data) { return rand(1, 1000); }
function login_as_admin() { /* ... */ }
function get_all_product_stock_levels() {
    return ['Phone X' => 30, 'Tablet Y' => 10];
}
function admin_update_product_stock($productId, $newStock) {
    if ($newStock < 0) {
        return ['success' => false, 'message' => 'Stock cannot be negative'];
    }
    if ($productId === 9999) {
        return ['success' => false, 'message' => 'Product not found'];
    }
    return ['success' => true];
}
function get_product_stock_level($productId) {
    if ($productId === 1) return 25;
    if ($productId === 2) return 1;
    return 5;
}
function get_low_stock_warnings() {
    return ['Camera'];
}