<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.3 – Fixed Menu on PC
 *
 * User Story:
 * As a desktop (PC) user
 * I want the main menu to remain visible at the top of the screen
 * So that I can easily access navigation options while scrolling
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.3.1 – Fixed Menu is Visible on Desktop
 * 6.3.2 – Menu Remains Fixed While Scrolling
 * 6.3.3 – Menu is Not Obtrusive
 */
class Test_6_3_FixedMenuPCTest extends TestCase
{
    /**
     * 6.3.1 – Fixed Menu is Visible on Desktop
     * Given I am viewing the application on a desktop-sized screen
     * When the page loads
     * Then the main navigation/menu is visible at the top of the page
     */
    public function test_6_3_1_FixedMenuVisibleOnDesktop()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1440, 900)); // Desktop size

        $crawler = $client->request('GET', 'http://localhost/'); // Change to your actual home URL

        // Try common nav selectors; adjust as appropriate for your app
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Main navigation/menu should be present on desktop.');

        $element = $nav->getElement(0);

        // Ensure nav is visible and at the top of the viewport
        $isDisplayed = $client->executeScript("return arguments[0].offsetParent !== null;", [$element]);
        $rect = $client->executeScript("return arguments[0].getBoundingClientRect();", [$element]);
        $this->assertTrue($isDisplayed, 'Main menu should be visible.');
        $this->assertTrue($rect['top'] >= 0 && $rect['top'] < 100, 'Menu should be at the top of the page.');
    }

    /**
     * 6.3.2 – Menu Remains Fixed While Scrolling
     * Given I am on a desktop viewport
     * When I scroll down the page
     * Then the main menu remains fixed at the top and does not disappear
     */
    public function test_6_3_2_MenuRemainsFixedWhileScrolling()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1440, 900));

        $crawler = $client->request('GET', 'http://localhost/');

        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Main navigation/menu should be present on desktop.');
        $element = $nav->getElement(0);

        // Get initial nav position
        $rectBefore = $client->executeScript("return arguments[0].getBoundingClientRect();", [$element]);

        // Scroll down the page
        $client->executeScript("window.scrollTo(0, 1000);");
        // Wait for scroll event
        usleep(250000);

        // Get nav position after scroll
        $rectAfter = $client->executeScript("return arguments[0].getBoundingClientRect();", [$element]);
        // The nav should still be at the top of the viewport (top close to 0)
        $this->assertTrue($rectAfter['top'] >= 0 && $rectAfter['top'] < 100, 'Menu should remain fixed at the top while scrolling.');
        // Optionally: ensure the nav is still visible
        $isDisplayed = $client->executeScript("return arguments[0].offsetParent !== null;", [$element]);
        $this->assertTrue($isDisplayed, 'Main menu should remain visible while scrolling.');
    }

    /**
     * 6.3.3 – Menu is Not Obtrusive
     * Given the menu is fixed
     * When I interact with the page content
     * Then the menu does not overlap or obscure important content
     */
    public function test_6_3_3_MenuNotObtrusive()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1440, 900));

        $crawler = $client->request('GET', 'http://localhost/');

        // Find the nav and the first main content element
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Main navigation/menu should be present.');
        $element = $nav->getElement(0);

        // Assume main content is <main>, .main-content, or #content
        $content = $crawler->filter('main, .main-content, #content');
        $this->assertGreaterThan(0, $content->count(), 'Main content should be present.');
        $contentElement = $content->getElement(0);

        // Get nav and content bounding rects
        $navRect = $client->executeScript("return arguments[0].getBoundingClientRect();", [$element]);
        $contentRect = $client->executeScript("return arguments[0].getBoundingClientRect();", [$contentElement]);

        // The bottom of the nav should be at or above the top of the content (no overlap)
        $this->assertTrue(
            $navRect['bottom'] <= $contentRect['top'] + 2,
            'Menu should not overlap or obscure main content.'
        );
    }
}