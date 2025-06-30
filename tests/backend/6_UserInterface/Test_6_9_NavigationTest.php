<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.9 – Navigation
 *
 * User Story:
 * As an application user
 * I want clear and consistent navigation throughout the site
 * So that I can easily find my way to key pages and features
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.9.1 – Main Navigation is Consistent Across Pages
 * 6.9.2 – Navigation Links Work as Expected
 * 6.9.3 – Current Page is Clearly Indicated in Navigation
 */
class Test_6_9_NavigationTest extends TestCase
{
    /**
     * 6.9.1 – Main Navigation is Consistent Across Pages
     * Given I am on any main page of the application
     * When the page loads
     * Then the main navigation menu is present and follows a consistent layout and style
     */
    public function test_6_9_1_MainNavigationConsistent()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'http://localhost/',
            'http://localhost/products',
            'http://localhost/cart',
            'http://localhost/profile',
        ];

        $firstNavHtml = null;
        foreach ($urls as $url) {
            $crawler = $client->request('GET', $url);
            $nav = $crawler->filter('nav, .main-menu, .navbar');
            $this->assertGreaterThan(0, $nav->count(), "Main navigation menu should be present on $url.");
            $navHtml = $nav->first()->html();

            if ($firstNavHtml === null) {
                $firstNavHtml = $navHtml;
            } else {
                // Remove whitespace for comparison
                $this->assertEquals(
                    preg_replace('/\s+/', '', $firstNavHtml),
                    preg_replace('/\s+/', '', $navHtml),
                    "Main navigation HTML should be consistent between $urls[0] and $url."
                );
            }
        }
    }

    /**
     * 6.9.2 – Navigation Links Work as Expected
     * Given I see navigation links (e.g., Home, Products, Cart, Profile)
     * When I click a navigation link
     * Then I am taken to the correct destination page
     */
    public function test_6_9_2_NavigationLinksWork()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/');

        $navLinks = [
            'Home' => '/',
            'Products' => '/products',
            'Cart' => '/cart',
            'Profile' => '/profile',
        ];

        foreach ($navLinks as $label => $path) {
            $link = $crawler->selectLink($label);
            $this->assertGreaterThan(0, $link->count(), "Navigation link '$label' should be present.");
            $link->click();
            $client->waitForLocation("http://localhost$path", 5);
            $this->assertStringEndsWith(
                $path,
                parse_url($client->getCurrentURL(), PHP_URL_PATH),
                "Navigation link '$label' should go to $path."
            );
            // Go back to home for next iteration
            $crawler = $client->request('GET', 'http://localhost/');
        }
    }

    /**
     * 6.9.3 – Current Page is Clearly Indicated in Navigation
     * Given I am on a specific page
     * When I view the navigation menu
     * Then there is a clear visual indication of the current/active page
     */
    public function test_6_9_3_CurrentPageIndicated()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $pages = [
            ['label' => 'Home', 'url' => 'http://localhost/', 'path' => '/'],
            ['label' => 'Products', 'url' => 'http://localhost/products', 'path' => '/products'],
            ['label' => 'Cart', 'url' => 'http://localhost/cart', 'path' => '/cart'],
            ['label' => 'Profile', 'url' => 'http://localhost/profile', 'path' => '/profile'],
        ];

        foreach ($pages as $page) {
            $crawler = $client->request('GET', $page['url']);
            // Find the active navigation element (commonly has .active or aria-current)
            $nav = $crawler->filter('nav, .main-menu, .navbar');
            $this->assertGreaterThan(0, $nav->count(), "Navigation should be present on {$page['url']}.");

            $activeLink = $nav->filter('.active, [aria-current="page"], .nav-link.active, .menu-item.active');
            $this->assertGreaterThan(
                0,
                $activeLink->count(),
                "Active/current page should be visually indicated in navigation on {$page['url']}."
            );
            $this->assertStringContainsString(
                $page['label'],
                $activeLink->text(),
                "Active navigation element should contain '{$page['label']}' on {$page['url']}."
            );
        }
    }
}