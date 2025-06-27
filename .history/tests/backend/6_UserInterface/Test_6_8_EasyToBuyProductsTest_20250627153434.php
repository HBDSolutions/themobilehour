<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.8 – Easy to Buy Products
 *
 * User Story:
 * As an application user
 * I want to buy products online with minimal steps and clear guidance
 * So that I can complete my purchase quickly and without confusion
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.8.1 – "Add to Cart" Button is Clearly Visible on Product Details
 * 6.8.2 – Cart is Easily Accessible from All Pages
 * 6.8.3 – Checkout Process is Simple and Linear
 * 6.8.4 – Purchase Confirmation is Clear and Immediate
 */
class Test_6_8_EasyToBuyProductsTest extends TestCase
{
    /**
     * 6.8.1 – "Add to Cart" Button is Clearly Visible on Product Details
     * Given I am viewing a product details page
     * When the page loads
     * Then there is a clearly visible "Add to Cart" button
     */
    public function test_6_8_1_AddToCartVisible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Adjust with a real product details URL
        $crawler = $client->request('GET', 'http://localhost/products/1');

        $button = $crawler->selectButton('Add to Cart');
        $this->assertGreaterThan(0, $button->count(), '"Add to Cart" button should be visible on product details page.');

        $isDisplayed = $client->executeScript('return arguments[0].offsetParent !== null;', [$button->getElement(0)]);
        $this->assertTrue($isDisplayed, '"Add to Cart" button should be displayed.');
    }

    /**
     * 6.8.2 – Cart is Easily Accessible from All Pages
     * Given I am browsing the application
     * When I want to view my cart
     * Then there is a cart icon or link visible on all pages
     */
    public function test_6_8_2_CartAccessible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'http://localhost/',
            'http://localhost/products',
            'http://localhost/products/1',
            'http://localhost/cart',
        ];
        foreach ($urls as $url) {
            $crawler = $client->request('GET', $url);
            $cart = $crawler->filter('a[href*="cart"], .cart-icon, .nav-cart, [data-testid="cart-link"]');
            $this->assertGreaterThan(
                0,
                $cart->count(),
                "Cart link or icon should be visible on $url"
            );
            $isDisplayed = $client->executeScript('return arguments[0].offsetParent !== null;', [$cart->getElement(0)]);
            $this->assertTrue($isDisplayed, "Cart link or icon should be displayed on $url");
        }
    }

    /**
     * 6.8.3 – Checkout Process is Simple and Linear
     * Given I have added products to my cart
     * When I proceed to checkout
     * Then I am guided through a simple, step-by-step process to complete my purchase
     */
    public function test_6_8_3_CheckoutIsSimple()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Add a product to the cart first
        $crawler = $client->request('GET', 'http://localhost/products/1');
        $button = $crawler->selectButton('Add to Cart');
        $button->click();
        $client->waitFor('.cart-count, .cart-badge, .cart-dialog, .alert-success', 5);

        // Go to cart page and click "Checkout"
        $crawler = $client->request('GET', 'http://localhost/cart');
        $checkoutButton = $crawler->selectButton('Checkout');
        $this->assertGreaterThan(0, $checkoutButton->count(), 'Checkout button should be present on cart page.');
        $checkoutButton->click();

        // Wait for checkout page
        $client->waitFor('.checkout-page, #checkout, form[action*="checkout"]', 5);

        // Assert linear step indicator or clear stepwise process
        $checkout = $client->getCrawler()->filter('.checkout-page, #checkout, form[action*="checkout"]');
        $this->assertGreaterThan(0, $checkout->count(), 'Should be on the checkout page.');

        // Look for step indicator or single-step form
        $steps = $client->getCrawler()->filter('.step-indicator, .checkout-step, .progress-bar, .checkout-steps');
        $this->assertTrue(
            $steps->count() > 0 || $checkout->count() === 1,
            'Checkout should be linear and simple, with steps or a single clear form.'
        );
    }

    /**
     * 6.8.4 – Purchase Confirmation is Clear and Immediate
     * Given I have completed the checkout process
     * When my payment is successful
     * Then I receive a clear confirmation message and order summary
     */
    public function test_6_8_4_PurchaseConfirmation()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Go directly to checkout page for test, or follow add-to-cart/checkout flow
        $crawler = $client->request('GET', 'http://localhost/checkout');

        // Fill in checkout form; adjust names/selectors as needed
        $form = $crawler->filter('form')->first();
        $this->assertGreaterThan(0, $form->count(), 'Checkout form should be present.');

        $form->fill([
            'name' => 'Test User',
            'address' => '123 Test St',
            'city' => 'Testville',
            'zip' => '12345',
            'card_number' => '4111111111111111',
            'card_expiry' => '12/30',
            'card_cvc' => '123',
        ]);
        $form->submit();

        // Wait for confirmation
        $client->waitFor('.order-confirmation, #order-confirmation, .alert-success', 10);

        $confirmation = $client->getCrawler()->filter('.order-confirmation, #order-confirmation, .alert-success');
        $this->assertGreaterThan(0, $confirmation->count(), 'Confirmation message should be visible after purchase.');
        $this->assertStringContainsString(
            'Thank you',
            $confirmation->text(),
            'Confirmation message should thank the user or confirm the order.'
        );

        // Order summary check (optional)
        $summary = $confirmation->filter('.order-summary, #order-summary');
        $this->assertTrue(
            $summary->count() > 0 || stripos($confirmation->text(), 'order summary') !== false,
            'Order summary should be present in confirmation.'
        );
    }
}