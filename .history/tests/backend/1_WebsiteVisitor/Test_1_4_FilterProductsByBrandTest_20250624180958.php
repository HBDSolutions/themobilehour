<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.4 – Filter Products By Brand
 *
 * User Story:
 * As a website visitor,
 * I want to filter the product list by brand,
 * So that I can quickly find products from brands I trust or prefer.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.4.1 – Brand Filters Appear
 * 1.4.2 – Filter By One Brand
 * 1.4.3 – Filter By Multiple Brands
 * 1.4.4 – No Products For Selected Brand
 *
 * See acceptance criteria and scenarios:
 * @see https://github.com/HBDSolutions/themobilehour/blob/main/tests/backend/1_WebsiteVisitor/Test_1_4_FilterProductsByBrandTest.md
 */
class Test_1_4_FilterProductsByBrandTest extends TestCase
{
    /*
    * 1.4.1 – Brand Filters Appear
    * Given a visitor is on the product browse page
    * When the page loads
    * Then all available brands are shown as filter options
    */
    public function test_1_4_1_BrandFiltersAppear()
    {
        $brands = ['Samsung', 'Apple', 'Xiaomi'];
        seed_brands($brands);
        seed_products([
            ['brand' => 'Samsung', 'name' => 'Galaxy S22'],
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
            ['brand' => 'Xiaomi', 'name' => 'Mi 11'],
        ]);
        $response = get_products_browse_page();
        foreach ($brands as $brand) {
            $this->assertStringContainsString($brand, $response);
        }
    }

    /*
    * 1.4.2 – Filter By One Brand
    * Given a visitor selects a single brand
    * When the filter is applied
    * Then only products from that brand are shown
    */
    public function test_1_4_2_FilterByOneBrand()
    {
        $brand = 'Samsung';
        seed_products([
            ['brand' => 'Samsung', 'name' => 'Galaxy A52'],
            ['brand' => 'Apple', 'name' => 'iPhone 12'],
        ]);
        $response = get_products_browse_page(['brand' => $brand]);
        $this->assertStringContainsString('Galaxy A52', $response);
        $this->assertStringNotContainsString('iPhone 12', $response);
    }

    /*
    * 1.4.3 – Filter By Multiple Brands
    * Given a visitor selects multiple brands
    * When the filter is applied
    * Then only products matching any of the selected brands are shown
    */
    public function test_1_4_3_FilterByMultipleBrands()
    {
        $brands = ['Samsung', 'Apple'];
        seed_products([
            ['brand' => 'Samsung', 'name' => 'Galaxy S21'],
            ['brand' => 'Apple', 'name' => 'iPhone 13'],
            ['brand' => 'Xiaomi', 'name' => 'Mi 11'],
        ]);
        $response = get_products_browse_page(['brand' => $brands]);
        $this->assertStringContainsString('Galaxy S21', $response);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringNotContainsString('Mi 11', $response);
    }

    /*
    * 1.4.4 – No Products For Selected Brand
    * Given a visitor selects a brand with no products
    * When the filter is applied
    * Then a message indicates no products available for that brand
    */
    public function test_1_4_4_NoProductsForSelectedBrand()
    {
        seed_products([
            ['brand' => 'Apple', 'name' => 'iPhone SE'],
        ]);
        $response = get_products_browse_page(['brand' => 'Samsung']);
        $this->assertStringContainsString('No products are available', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_brands(array $brands) { /* ... */ }
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }