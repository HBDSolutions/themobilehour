<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.7 – Search Products by Name or Model
 *
 * User Story:
 * As a website visitor,
 * I need to search for products by name or model,
 * So that I can quickly find the product I am looking for.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.7.1 – Search by Product Name
 * 1.7.2 – Search by Product Model
 * 1.7.3 – No Matching Products
 * 1.7.4 – Search Reset/Empty Query
 */
class Test_1_7_SearchProductsByNameOrModelTest extends TestCase
{
    /*
    * 1.7.1 – Search by Product Name
    * Given a website visitor is on the products/browse page
    * When the visitor enters a product name in the search box and submits
    * Then
    * - Only products matching the entered name are displayed
    * - The search term is highlighted in the results (if supported)
    */
    public function test_1_7_1_SearchByProductName()
    {
        seed_products([
            ['name' => 'iPhone 13', 'model' => 'A2633'],
            ['name' => 'Galaxy S22', 'model' => 'SM-S901B'],
        ]);
        $response = get_products_browse_page(['search' => 'iPhone 13']);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringNotContainsString('Galaxy S22', $response);
        $this->assertStringContainsString('<mark>iPhone 13</mark>', $response); // Highlighted
    }

    /*
    * 1.7.2 – Search by Product Model
    * Given a website visitor is on the products/browse page
    * When the visitor enters a product model in the search box and submits
    * Then
    * - Only products matching the entered model are displayed
    */
    public function test_1_7_2_SearchByProductModel()
    {
        seed_products([
            ['name' => 'iPhone 13', 'model' => 'A2633'],
            ['name' => 'Galaxy S22', 'model' => 'SM-S901B'],
        ]);
        $response = get_products_browse_page(['search' => 'SM-S901B']);
        $this->assertStringContainsString('Galaxy S22', $response);
        $this->assertStringNotContainsString('iPhone 13', $response);
    }

    /*
    * 1.7.3 – No Matching Products
    * Given the visitor enters a name or model that does not match any available product
    * When the search is performed
    * Then
    * - A message is displayed indicating no products are found
    */
    public function test_1_7_3_NoMatchingProducts()
    {
        seed_products([
            ['name' => 'iPhone 13', 'model' => 'A2633'],
        ]);
        $response = get_products_browse_page(['search' => 'Pixel']);
        $this->assertStringContainsString('no products are found', strtolower($response));
    }

    /*
    * 1.7.4 – Search Reset/Empty Query
    * Given a search is performed
    * When the search box is cleared and the search is submitted again
    * Then
    * - All available products are displayed
    */
    public function test_1_7_4_SearchResetOrEmptyQuery()
    {
        seed_products([
            ['name' => 'iPhone 13', 'model' => 'A2633'],
            ['name' => 'Galaxy S22', 'model' => 'SM-S901B'],
        ]);
        $response = get_products_browse_page(['search' => '']);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Galaxy S22', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }