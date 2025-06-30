<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 7.6 – Security Protocols
 *
 * User Story:
 * As an application user
 * I want the site to use strong security protocols
 * So that my personal data and activity are protected
 *
 * Acceptance Criteria / BDD Scenarios:
 * 7.6.1 – All Sensitive Data Transmissions Use HTTPS
 * 7.6.2 – Security Headers Are Present in Responses
 * 7.6.3 – CSRF Protection Is Enabled on Forms
 */
class Test_7_6_SecurityProtocolsTest extends TestCase
{
    /**
     * 7.6.1 – All Sensitive Data Transmissions Use HTTPS
     * Given I am using the application
     * When I submit login, registration, or other sensitive forms
     * Then the data is transmitted via HTTPS
     */
    public function test_7_6_1_HTTPSForSensitiveData()
    {
        // For this test, you must have test environment accessible via HTTPS
        $loginUrl = 'https://localhost/login';
        $registerUrl = 'https://localhost/register';

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Login form
        $crawler = $client->request('GET', $loginUrl);
        $form = $crawler->selectButton('Login')->form();
        $this->assertStringStartsWith('https://', $loginUrl, 'Login form must be served over HTTPS.');
        $this->assertEquals('https', parse_url($client->getCurrentURL(), PHP_URL_SCHEME), 'Login page must be HTTPS.');

        // Registration form
        $crawler = $client->request('GET', $registerUrl);
        $form = $crawler->selectButton('Register')->form();
        $this->assertStringStartsWith('https://', $registerUrl, 'Registration form must be served over HTTPS.');
        $this->assertEquals('https', parse_url($client->getCurrentURL(), PHP_URL_SCHEME), 'Registration page must be HTTPS.');
    }

    /**
     * 7.6.2 – Security Headers Are Present in Responses
     * Given I access any page
     * When the HTTP response is received
     * Then the response includes security-related headers (e.g., Strict-Transport-Security, X-Content-Type-Options, Content-Security-Policy, X-Frame-Options)
     */
    public function test_7_6_2_SecurityHeadersPresent()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $url = 'https://localhost/';
        $client->request('GET', $url);

        // Get response headers using Panther internal client
        $headers = $client->getInternalResponse()->getHeaders();

        $this->assertArrayHasKey('strict-transport-security', $headers, 'Strict-Transport-Security header must be present.');
        $this->assertArrayHasKey('x-content-type-options', $headers, 'X-Content-Type-Options header must be present.');
        $this->assertArrayHasKey('content-security-policy', $headers, 'Content-Security-Policy header must be present.');
        $this->assertArrayHasKey('x-frame-options', $headers, 'X-Frame-Options header must be present.');
        // Optionally: Check header values
        $this->assertStringContainsString('max-age=', strtolower(implode(' ', $headers['strict-transport-security'])), 'Strict-Transport-Security should have max-age.');
        $this->assertEquals('nosniff', strtolower(implode(' ', $headers['x-content-type-options'])), 'X-Content-Type-Options should be nosniff.');
    }

    /**
     * 7.6.3 – CSRF Protection Is Enabled on Forms
     * Given I submit a sensitive form (login, registration, profile update, etc.)
     * When I inspect the form
     * Then a CSRF token is present and required for submission
     */
    public function test_7_6_3_CSRFProtectionOnForms()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'https://localhost/login' => 'Login',
            'https://localhost/register' => 'Register',
            'https://localhost/profile' => 'Update'
        ];

        foreach ($urls as $url => $button) {
            $crawler = $client->request('GET', $url);
            $form = $crawler->selectButton($button)->form();
            // Look for hidden input with typical CSRF names
            $csrfField = null;
            foreach (['csrf', '_csrf', 'csrf_token', '_token'] as $name) {
                if (isset($form[$name])) {
                    $csrfField = $form[$name];
                    break;
                }
            }
            $this->assertNotNull($csrfField, "CSRF token should be present in $url form.");

            // Try submitting the form without CSRF token (simulate removal)
            unset($form['csrf'], $form['_csrf'], $form['csrf_token'], $form['_token']);
            $client->submit($form);
            // Should get error/redirect, not logged in/registered/profile updated
            $client->waitFor('.alert-danger, .error-message, .form-error', 3);
            $error = $client->getCrawler()->filter('.alert-danger, .error-message, .form-error');
            $this->assertGreaterThan(
                0,
                $error->count(),
                "Form submission without CSRF token should be rejected on $url."
            );
        }
    }
}