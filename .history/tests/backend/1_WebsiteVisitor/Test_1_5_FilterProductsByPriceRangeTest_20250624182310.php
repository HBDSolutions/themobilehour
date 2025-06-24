<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.5 – Filter Products by Price Range
 *
 * User Story:
 * As a website visitor,
 * I need to filter available products by price range,
 * So that I can select from the products within my budget.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.5.1 – Filter Products Within a Price Range
 * 1.5.2 – No Products Match Selected Price Range
 * 1.5.3 – Remove Price Filter
 */
class Test_1_5_FilterProductsByPriceRangeTest extends TestCase
{
    /*
    * 1.5.1 – Filter Products Within a Price Range
    * Given a website visitor is on the products/browse page
    * When the visitor selects a minimum and maximum price range
    * Then
    * - Only products with prices within the selected range are displayed
    * - The price filter controls remain visible and reflect the selected range
    */
    public function test_1_5_1_FilterWithinPriceRange()
    {
        seed_products([
            ['name' => 'iPhone 13', 'price' => 1000],
            ['name' => 'Galaxy S22', 'price' => 800],
            ['name' => 'Nokia 3310', 'price' => 50],
        ]);
        $response = get_products_browse_page(['price_min' => 700, 'price_max' => 1200]);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Galaxy S22', $response);
        $this->assertStringNotContainsString('Nokia 3310', $response);
        $this->assertStringContainsString('700', $response); // Filter control shows min
        $this->assertStringContainsString('1200', $response); // Filter control shows max
    }

    /*
    * 1.5.2 – No Products Match Selected Price Range
    * Given a website visitor selects a price range
    * When no products are available within that range
    * Then
    * - A message is displayed indicating no products are available within the selected range
    */
    public function test_1_5_2_NoProductsInPriceRange()
    {
        seed_products([
            ['name' => 'iPhone 13', 'price' => 1000],
            ['name' => 'Galaxy S22', 'price' => 800],
        ]);
        $response = get_products_browse_page(['price_min' => 1500, 'price_max' => 2000]);
        $this->assertStringContainsString('no products are available', strtolower($response));
    }

    /*
    * 1.5.3 – Remove Price Filter
    * Given a price filter is applied
    * When the visitor removes the filter or resets the price range
    * Then
    * - All available products are displayed again
    */
    public function test_1_5_3_RemovePriceFilter()
    {
        seed_products([
            ['name' => 'iPhone 13', 'price' => 1000],
            ['name' => 'Galaxy S22', 'price' => 800],
        ]);
        $response = get_products_browse_page(); // No filters
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Galaxy S22', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }