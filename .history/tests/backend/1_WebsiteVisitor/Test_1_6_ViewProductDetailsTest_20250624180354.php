<?php

/**
 * Test 1.6 – View Product Details
 *
 * See acceptance criteria and scenarios:
 * @see https://github.com/HBDSolutions/themobilehour/blob/main/tests/backend/1_WebsiteVisitor/Test_1_6_ViewProductDetailsTest.md
 */

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

class Test_1_6_ViewProductDetailsTest extends TestCase
{
    /**
     * 1.6.1 – Product Details Page Loads
     * Given a visitor selects a product from the browse page
     * When they visit the product details page
     * Then product details are displayed
     */
    public function test_1_6_1_ProductDetailsPageLoads()
    {
        // Arrange
        $product = ['id' => 100, 'name' => 'iPhone 15', 'price' => 1200, 'brand' => 'Apple', 'description' => 'Latest iPhone'];
        seed_products([$product]);

        // Act
        $response = get_product_details_page($product['id']);

        // Assert
        $this->assertStringContainsString('iPhone 15', $response);
        $this->assertStringContainsString('1200', $response);
        $this->assertStringContainsString('Apple', $response);
        $this->assertStringContainsString('Latest iPhone', $response);
    }

    /**
     * 1.6.2 – Invalid Product ID
     * Given a visitor goes to a product page with an invalid ID
     * Then a not found message is shown
     */
    public function test_1_6_2_InvalidProductId()
    {
        // Arrange: No products seeded

        // Act
        $response = get_product_details_page(404);

        // Assert
        $this->assertStringContainsString('Product not found', $response);
    }

    /**
     * 1.6.3 – Product Images Appear
     * Given a product has images
     * When visiting its details page
     * Then images are shown
     */
    public function test_1_6_3_ProductImagesAppear()
    {
        // Arrange
        $product = ['id' => 101, 'name' => 'Galaxy S22', 'images' => ['galaxy_s22_1.jpg', 'galaxy_s22_2.jpg']];
        seed_products([$product]);

        // Act
        $response = get_product_details_page($product['id']);

        // Assert
        foreach ($product['images'] as $img) {
            $this->assertStringContainsString($img, $response);
        }
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_product_details_page($id) { return ''; /* ... */ }