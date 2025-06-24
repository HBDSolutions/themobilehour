<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.3 – Browse All Available Products
 *
 * User Story:
 * As a website visitor
 * I need to browse all available products
 * So that I can compare and select my favourites
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.3.1 – View All Products
 * 1.3.2 – Products Are Sortable and Pageable
 * 1.3.3 – Product Comparison Features
 * 1.3.4 – No Products Available
 */
class Test_1_3_BrowseAllProductsTest extends TestCase
{
    /*
    * 1.3.1 – View All Products
    * Given a website visitor is on the products/browse page
    * When the page loads
    * Then
    * - All available products are displayed
    * - Each product shows key information (e.g., name, image, price, short description)
    */
    public function test_1_3_1_ViewAllProducts()
    {
        // Arrange: Seed several products in the database
        $products = [
            [
                'name' => 'Phone A',
                'image' => 'phone_a.jpg',
                'price' => '199.99',
                'short_description' => 'Affordable smartphone'
            ],
            [
                'name' => 'Phone B',
                'image' => 'phone_b.jpg',
                'price' => '299.99',
                'short_description' => 'Mid-range smartphone'
            ],
        ];
        seed_products($products);

        // Act: Simulate visiting the products/browse page
        $response = get_products_browse_page();

        // Assert: All products and their key info are shown
        foreach ($products as $product) {
            $this->assertStringContainsString($product['name'], $response);
            $this->assertStringContainsString($product['image'], $response);
            $this->assertStringContainsString($product['price'], $response);
            $this->assertStringContainsString($product['short_description'], $response);
        }
    }

    /*
    * 1.3.2 – Products Are Sortable and Pageable
    * Given there are more products than can fit on a single page
    * When the visitor browses the product list
    * Then
    * - Products are divided into pages or can be loaded dynamically
    * - Sorting options (e.g., by price, popularity, newest) are available
    */
    public function test_1_3_2_ProductsAreSortableAndPageable()
    {
        // Arrange: Seed many products to require pagination
        $products = [];
        for ($i = 1; $i <= 25; $i++) {
            $products[] = [
                'name' => "Phone $i",
                'image' => "phone_$i.jpg",
                'price' => (100 + $i) . '.99',
                'short_description' => "Phone #$i"
            ];
        }
        seed_products($products);

        // Act: Load first and second product pages
        $page1 = get_products_browse_page(['page' => 1]);
        $page2 = get_products_browse_page(['page' => 2]);

        // Assert: Pagination controls are present
        $this->assertStringContainsString('class="pagination"', $page1);

        // Assert: Sorting options are present
        $this->assertStringContainsString('Sort by', $page1);
        $this->assertStringContainsString('Price', $page1);
        $this->assertStringContainsString('Popularity', $page1);
        $this->assertStringContainsString('Newest', $page1);

        // Assert: Products are split across pages
        $this->assertNotEquals($page1, $page2);
    }

    /*
    * 1.3.3 – Product Comparison Features
    * Given a website visitor is browsing products
    * When the visitor marks products as favourites or for comparison
    * Then
    * - The visitor can view a list of selected favourites
    * - Optional: The visitor can compare selected products side by side
    */
    public function test_1_3_3_ProductComparisonFeatures()
    {
        // Arrange: Seed products and simulate a visitor
        $products = [
            ['id' => 1, 'name' => 'Phone X'],
            ['id' => 2, 'name' => 'Phone Y'],
        ];
        seed_products($products);
        $visitorId = create_test_visitor();

        // Act: Mark products as favourites
        mark_product_favourite($visitorId, 1);
        mark_product_favourite($visitorId, 2);

        // Assert: Favourites list shows selected products
        $favouritesPage = get_favourites_page($visitorId);
        $this->assertStringContainsString('Phone X', $favouritesPage);
        $this->assertStringContainsString('Phone Y', $favouritesPage);

        // Act: Compare selected products
        $comparePage = get_compare_page($visitorId, [1, 2]);
        // Assert: Comparison page displays both products
        $this->assertStringContainsString('Phone X', $comparePage);
        $this->assertStringContainsString('Phone Y', $comparePage);
        $this->assertStringContainsString('Comparison Table', $comparePage);
    }

    /*
    * 1.3.4 – No Products Available
    * Given there are no products in the system
    * When the visitor browses the products page
    * Then
    * - A message is displayed indicating no products are available
    */
    public function test_1_3_4_NoProductsAvailable()
    {
        // Arrange: Ensure no products exist
        clear_all_products();

        // Act: Visit the products browse page
        $response = get_products_browse_page();

        // Assert: No products message is shown
        $this->assertStringContainsString('No products are available', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:

function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }
function clear_all_products() { /* ... */ }
function create_test_visitor() { return 123; /* ... */ }
function mark_product_favourite($visitorId, $productId) { /* ... */ }
function get_favourites_page($visitorId) { return ''; /* ... */ }
function get_compare_page($visitorId, array $productIds) { return ''; /* ... */ }
