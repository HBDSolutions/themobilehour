<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.2 – Hamburger Menu on Mobile
 *
 * User Story:
 * As a mobile user
 * I want a hamburger menu to access navigation options
 * So that the interface is clean and usable on small screens
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.2.1 – Hamburger Menu is Displayed on Mobile
 * 6.2.2 – Hamburger Menu Opens Navigation
 * 6.2.3 – Hamburger Menu Closes After Selection
 */
class Test_6_2_HamburgerMenuMobileTest extends TestCase
{
    /**
     * 6.2.1 – Hamburger Menu is Displayed on Mobile
     * Given I am viewing the application on a mobile device or with a narrow viewport
     * When the page loads
     * Then a hamburger menu icon is visible in the main navigation/header
     * And the standard navigation links are hidden
     */
    public function test_6_2_1_HamburgerMenuDisplayed()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(375, 667)); // iPhone size

        $crawler = $client->request('GET', 'http://localhost/'); // Change to your home URL

        // Hamburger icon (usually button with aria-label or class)
        $hamburger = $crawler->filter('button[aria-label="Open navigation"], .hamburger, .navbar-toggler');
        $this->assertGreaterThan(0, $hamburger->count(), 'Hamburger menu icon should be visible on mobile.');

        // Standard nav links should be hidden
        $navLinks = $crawler->filter('.main-nav a, nav a, .navbar-nav a');
        $isVisible = false;
        foreach ($navLinks as $link) {
            $display = $client->executeScript('return window.getComputedStyle(arguments[0]).display;', [$link]);
            if ($display !== 'none') {
                $isVisible = true;
                break;
            }
        }
        $this->assertFalse($isVisible, 'Standard navigation links should be hidden on mobile.');
    }

    /**
     * 6.2.2 – Hamburger Menu Opens Navigation
     * Given the hamburger menu icon is visible
     * When I tap the hamburger menu
     * Then the main navigation options are displayed as a menu or drawer
     */
    public function test_6_2_2_HamburgerMenuOpensNav()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(375, 667));

        $crawler = $client->request('GET', 'http://localhost/');

        $hamburger = $crawler->filter('button[aria-label="Open navigation"], .hamburger, .navbar-toggler');
        $this->assertGreaterThan(0, $hamburger->count(), 'Hamburger menu icon should be visible.');

        $hamburger->click();
        $client->waitFor('.mobile-nav, .drawer-nav, .menu-open, nav[aria-expanded="true"]', 5);

        // Now main nav should be visible
        $navMenu = $crawler->filter('.mobile-nav, .drawer-nav, .menu-open, nav[aria-expanded="true"]');
        $this->assertGreaterThan(0, $navMenu->count(), 'Navigation menu should be displayed after hamburger click.');
    }

    /**
     * 6.2.3 – Hamburger Menu Closes After Selection
     * Given the navigation menu is open
     * When I tap a navigation link
     * Then the navigation menu closes
     */
    public function test_6_2_3_HamburgerMenuClosesOnSelect()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(375, 667));

        $crawler = $client->request('GET', 'http://localhost/');

        $hamburger = $crawler->filter('button[aria-label="Open navigation"], .hamburger, .navbar-toggler');
        $hamburger->click();
        $client->waitFor('.mobile-nav, .drawer-nav, .menu-open, nav[aria-expanded="true"]', 5);

        // Click the first nav link in the open menu
        $navMenu = $crawler->filter('.mobile-nav a, .drawer-nav a, .menu-open a, nav[aria-expanded="true"] a');
        $this->assertGreaterThan(0, $navMenu->count(), 'There should be at least one navigation link in the menu.');
        $navMenu->first()->click();

        // Now the nav menu should be closed
        // Wait a moment for animation
        usleep(500000);
        $foundOpen = false;
        foreach (['.mobile-nav', '.drawer-nav', '.menu-open', 'nav[aria-expanded="true"]'] as $selector) {
            if ($client->findElements($selector)) {
                $foundOpen = true;
                break;
            }
        }
        $this->assertFalse($foundOpen, 'Navigation menu should close after selecting a link.');
    }
}