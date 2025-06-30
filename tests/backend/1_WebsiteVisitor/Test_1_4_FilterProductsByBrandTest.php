<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.4 – Filter Products by Brand
 *
 * User Story:
 * As a website visitor,
 * I need to filter available products by brand,
 * So that I can only select from the brands I prefer.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.4.1 – Filter Products by Single Brand
 * 1.4.2 – Filter Products by Multiple Brands
 * 1.4.3 – No Products Match Selected Brands
 * 1.4.4 – Remove Brand Filter
 */
class Test_1_4_FilterProductsByBrandTest extends TestCase
{
    /*
    * 1.4.1 – Filter Products by Single Brand
    * Given a website visitor is on the products/browse page
    * When the visitor selects a specific brand from the brand filter options
    * Then
    * - Only products from the selected brand are displayed
    * - The brand filter remains visible and selected
    */
    public function test_1_4_1_FilterBySingleBrand()
    {
        seed_brands(['Apple', 'Samsung']);
        seed_products([
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
            ['brand' => 'Samsung', 'name' => 'Galaxy S22'],
        ]);
        $response = get_products_browse_page(['brand' => 'Apple']);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringNotContainsString('Galaxy S22', $response);
        $this->assertStringContainsString('Apple', $response); // Filter remains visible
    }

    /*
    * 1.4.2 – Filter Products by Multiple Brands
    * Given a website visitor is on the products/browse page
    * When the visitor selects multiple brands from the filter options
    * Then
    * - Only products from the selected brands are displayed
    * - The selected brands remain highlighted
    */
    public function test_1_4_2_FilterByMultipleBrands()
    {
        seed_brands(['Apple', 'Samsung', 'Xiaomi']);
        seed_products([
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
            ['brand' => 'Samsung', 'name' => 'Galaxy S22'],
            ['brand' => 'Xiaomi', 'name' => 'Mi 12'],
        ]);
        $response = get_products_browse_page(['brand' => ['Apple', 'Samsung']]);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Galaxy S22', $response);
        $this->assertStringNotContainsString('Mi 12', $response);
        $this->assertStringContainsString('Apple', $response);
        $this->assertStringContainsString('Samsung', $response);
    }

    /*
    * 1.4.3 – No Products Match Selected Brands
    * Given a website visitor selects one or more brands in the filter
    * When no products are available for those brands
    * Then
    * - A message is displayed indicating no products are available for the selected brands
    */
    public function test_1_4_3_NoProductsMatchBrands()
    {
        seed_brands(['Apple', 'Samsung']);
        seed_products([
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
        ]);
        $response = get_products_browse_page(['brand' => 'Samsung']);
        $this->assertStringContainsString('no products are available', strtolower($response));
    }

    /*
    * 1.4.4 – Remove Brand Filter
    * Given a brand filter is applied
    * When the visitor removes the filter or resets all brand selections
    * Then
    * - All available products are displayed again
    */
    public function test_1_4_4_RemoveBrandFilter()
    {
        seed_brands(['Apple', 'Samsung']);
        seed_products([
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
            ['brand' => 'Samsung', 'name' => 'Galaxy S22'],
        ]);
        $response = get_products_browse_page(); // No filter applied
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Galaxy S22', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_brands(array $brands) { /* ... */ }
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }