<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.10 – Accessibility Features
 *
 * User Story:
 * As a user with disabilities
 * I want the application to provide accessibility features
 * So that I can use and navigate the site effectively
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.10.1 – Main Pages Pass Automated Accessibility Checks
 * 6.10.2 – All Interactive Elements are Keyboard Accessible
 * 6.10.3 – Pages Have Proper Landmarks and ARIA Roles
 * 6.10.4 – Supports Sufficient Contrast and Text Scaling
 */
class Test_6_10_AccessibilityFeaturesTest extends TestCase
{
    /**
     * 6.10.1 – Main Pages Pass Automated Accessibility Checks
     * Run axe-core or similar automated accessibility checker.
     */
    public function test_6_10_1_PagesPassA11yChecks()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'http://localhost/',
            'http://localhost/products',
            'http://localhost/cart',
            'http://localhost/checkout'
        ];

        foreach ($urls as $url) {
            $crawler = $client->request('GET', $url);

            // Inject axe-core for accessibility checking
            $axe = file_get_contents(__DIR__ . '/axe.min.js'); // Download axe.min.js for test env
            $client->executeScript($axe);
            $results = $client->executeScript('return await axe.run(document, { runOnly: { type: "tag", values: ["wcag2a", "wcag2aa"] } });');

            // Only allow minor or no violations
            $violations = $results['violations'];
            $critical = array_filter($violations, function($v) {
                return in_array('critical', $v['impact']) || in_array('serious', $v['impact']);
            });
            $this->assertCount(0, $critical, "Critical accessibility violations found on $url: " . json_encode($critical));
        }
    }

    /**
     * 6.10.2 – All Interactive Elements are Keyboard Accessible
     * Tab through interactive elements and ensure focus is visible and elements are operable.
     */
    public function test_6_10_2_KeyboardAccessible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/');

        // Get all focusable/interactable elements
        $tabbables = $client->executeScript(
            "return Array.from(document.querySelectorAll('a,button,input,select,textarea,[tabindex]'))
                    .filter(el => !el.disabled && el.tabIndex >= 0 && el.offsetParent !== null)
                    .map(el => el.outerHTML);"
        );
        $this->assertGreaterThan(0, count($tabbables), 'There should be focusable elements on the page.');

        // Tab through elements and check focus is visible (outline or style)
        foreach ($tabbables as $i => $elHtml) {
            // Focus element using JS
            $client->executeScript("document.querySelectorAll('a,button,input,select,textarea,[tabindex]')[$i].focus();");
            usleep(100000);

            $outline = $client->executeScript("
                var el = document.querySelectorAll('a,button,input,select,textarea,[tabindex]')[$i];
                var style = window.getComputedStyle(el);
                return style.outlineStyle !== 'none' && style.outlineWidth !== '0px';
            ");
            $this->assertTrue($outline, "Focusable element #$i should have visible focus outline.");
        }
    }

    /**
     * 6.10.3 – Pages Have Proper Landmarks and ARIA Roles
     * Check for nav, main, header, footer, and appropriate ARIA roles.
     */
    public function test_6_10_3_LandmarksAriaRoles()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'http://localhost/',
            'http://localhost/products',
            'http://localhost/cart',
            'http://localhost/checkout'
        ];

        foreach ($urls as $url) {
            $crawler = $client->request('GET', $url);

            // Look for main landmarks
            $this->assertGreaterThan(0, $crawler->filter('nav')->count(), "Nav landmark should be present on $url.");
            $this->assertGreaterThan(0, $crawler->filter('main')->count(), "Main landmark should be present on $url.");
            $this->assertGreaterThan(0, $crawler->filter('header')->count(), "Header should be present on $url.");
            $this->assertGreaterThan(0, $crawler->filter('footer')->count(), "Footer should be present on $url.");

            // Check ARIA roles
            $roles = [
                '[role="navigation"]',
                '[role="main"]',
                '[role="banner"]',
                '[role="contentinfo"]'
            ];
            foreach ($roles as $role) {
                $this->assertGreaterThan(
                    0,
                    $crawler->filter($role)->count(),
                    "ARIA role $role should be present on $url."
                );
            }
        }
    }

    /**
     * 6.10.4 – Supports Sufficient Contrast and Text Scaling
     * Check contrast for text and that zooming (text scaling) does not break layout/readability.
     */
    public function test_6_10_4_ContrastAndScaling()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/');

        // Inject axe-core for contrast checking
        $axe = file_get_contents(__DIR__ . '/axe.min.js');
        $client->executeScript($axe);
        $results = $client->executeScript('return await axe.run(document, { runOnly: { type: "rule", values: ["color-contrast"] } });');

        $violations = $results['violations'];
        $contrast = array_filter($violations, function($v) {
            return $v['id'] === 'color-contrast';
        });
        $this->assertCount(0, $contrast, "Color contrast issues found: " . json_encode($contrast));

        // Simulate text scaling by zooming in
        $client->executeScript('document.body.style.fontSize = "150%";');
        usleep(200000);

        // Check main content still visible and not overflowed
        $main = $crawler->filter('main');
        $this->assertGreaterThan(0, $main->count(), 'Main content should be present after scaling.');
        $overflow = $client->executeScript("
            var main = document.querySelector('main');
            return main.scrollWidth > main.clientWidth || main.scrollHeight > main.clientHeight;
        ");
        $this->assertFalse($overflow, 'Main content should remain readable and not overflow after text scaling.');
    }
}