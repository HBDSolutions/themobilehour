<?php

/**
 * Test 1.5 – Filter Products By Price Range
 *
 * See acceptance criteria and scenarios:
 * @see https://github.com/HBDSolutions/themobilehour/blob/main/tests/backend/1_WebsiteVisitor/Test_1_5_FilterProductsByPriceRangeTest.md
 */

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

class Test_1_5_FilterProductsByPriceRangeTest extends TestCase
{
    /**
     * 1.5.1 – Price Range Filters Appear
     * Given a visitor is on the product browse page
     * When the page loads
     * Then price range filter controls appear
     */
    public function test_1_5_1_PriceRangeFiltersAppear()
    {
        // Arrange
        seed_products([
            ['name' => 'Product 1', 'price' => 200],
            ['name' => 'Product 2', 'price' => 800],
        ]);

        // Act
        $response = get_products_browse_page();

        // Assert
        $this->assertStringContainsString('Price Range', $response);
        $this->assertStringContainsString('min', $response);
        $this->assertStringContainsString('max', $response);
    }

    /**
     * 1.5.2 – Filter By Price Range
     * Given a visitor sets a min and max price
     * When the filter is applied
     * Then only products within that price range are shown
     */
    public function test_1_5_2_FilterByPriceRange()
    {
        // Arrange
        seed_products([
            ['name' => 'Phone A', 'price' => 300],
            ['name' => 'Phone B', 'price' => 500],
            ['name' => 'Phone C', 'price' => 900],
        ]);

        // Act
        $response = get_products_browse_page(['min_price' => 300, 'max_price' => 600]);

        // Assert
        $this->assertStringContainsString('Phone A', $response);
        $this->assertStringContainsString('Phone B', $response);
        $this->assertStringNotContainsString('Phone C', $response);
    }

    /**
     * 1.5.3 – No Products In Price Range
     * Given a visitor sets a price range with no matching products
     * When the filter is applied
     * Then a message indicates no products are available in that range
     */
    public function test_1_5_3_NoProductsInPriceRange()
    {
        // Arrange
        seed_products([
            ['name' => 'Tablet X', 'price' => 1500],
        ]);

        // Act
        $response = get_products_browse_page(['min_price' => 100, 'max_price' => 500]);

        // Assert
        $this->assertStringContainsString('No products are available', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }