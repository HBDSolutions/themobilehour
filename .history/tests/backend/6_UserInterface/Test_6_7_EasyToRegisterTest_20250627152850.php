<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.7 – Easy to Register
 *
 * User Story:
 * As a new user
 * I want to easily register for an account
 * So that I can start using the application without unnecessary friction
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.7.1 – Registration Option is Prominently Visible
 * 6.7.2 – Registration Form is Simple and Clear
 * 6.7.3 – User Can Register Successfully
 * 6.7.4 – Errors are Clear for Invalid Registration
 */
class Test_6_7_EasyToRegisterTest extends TestCase
{
    /**
     * 6.7.1 – Registration Option is Prominently Visible
     * Given I am on the home page or login page
     * When the page loads
     * Then there is a clearly visible option to register or sign up
     */
    public function test_6_7_1_RegistrationOptionVisible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();

        // Check home page
        $crawler = $client->request('GET', 'http://localhost/');
        $registerLink = $crawler->selectLink('Register')->count() > 0 ||
                        $crawler->selectLink('Sign Up')->count() > 0;
        $this->assertTrue($registerLink, 'Registration option should be visible on the home page.');

        // Check login page
        $crawler = $client->request('GET', 'http://localhost/login');
        $registerLink = $crawler->selectLink('Register')->count() > 0 ||
                        $crawler->selectLink('Sign Up')->count() > 0;
        $this->assertTrue($registerLink, 'Registration option should be visible on the login page.');
    }

    /**
     * 6.7.2 – Registration Form is Simple and Clear
     * Given I have chosen to register
     * When the registration form is displayed
     * Then the form is concise, requests only essential information, and is easy to understand
     */
    public function test_6_7_2_RegistrationFormSimple()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/register');

        // Check for form existence and essential fields
        $form = $crawler->filter('form')->first();
        $this->assertGreaterThan(0, $form->count(), 'Registration form should be present.');

        $fields = [
            $form->filter('input[name="username"], input[name="email"]')->count() > 0,
            $form->filter('input[name="password"]')->count() > 0,
            $form->filter('input[name="confirm_password"], input[name="password_confirmation"]')->count() > 0, // optional
        ];
        $this->assertTrue($fields[0], 'Form should request username or email.');
        $this->assertTrue($fields[1], 'Form should request password.');
        // Password confirmation is optional but preferred for clarity
        $this->assertGreaterThanOrEqual(2, array_sum($fields), 'Form should request at least username/email and password.');
    }

    /**
     * 6.7.3 – User Can Register Successfully
     * Given I have filled out the registration form with valid information
     * When I submit the form
     * Then my account is created and I am logged in or shown a success message
     */
    public function test_6_7_3_UserCanRegister()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/register');

        // Fill out registration form
        $form = $crawler->selectButton('Register')->form();
        $unique = 'user' . uniqid();
        $form['username'] = $unique;
        $form['email'] = "$unique@example.com";
        $form['password'] = 'TestPass123!';
        if (isset($form['confirm_password'])) {
            $form['confirm_password'] = 'TestPass123!';
        }
        if (isset($form['password_confirmation'])) {
            $form['password_confirmation'] = 'TestPass123!';
        }

        $client->submit($form);

        // Wait for either a redirect or a success message
        $client->waitFor('.alert-success, .registration-success, .welcome-message, .dashboard, .home', 5);

        // Check for success indication
        $success = $client->getCrawler()->filter('.alert-success, .registration-success, .welcome-message')->count() > 0 ||
                   strpos($client->getCurrentURL(), '/dashboard') !== false ||
                   strpos($client->getCurrentURL(), '/home') !== false;
        $this->assertTrue($success, 'Should be logged in or shown a registration success message.');
    }

    /**
     * 6.7.4 – Errors are Clear for Invalid Registration
     * Given I submit the registration form with missing or invalid information
     * When the form is processed
     * Then I receive a clear, specific error message indicating what needs to be corrected
     */
    public function test_6_7_4_RegistrationErrorsClear()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/register');

        // Attempt to submit empty form
        $form = $crawler->selectButton('Register')->form();
        $client->submit($form);

        // Wait for error message
        $client->waitFor('.alert-danger, .error-message, .form-error', 3);

        // Check for error message
        $error = $client->getCrawler()->filter('.alert-danger, .error-message, .form-error');
        $this->assertGreaterThan(0, $error->count(), 'Clear error message should be shown for invalid registration.');

        // Optionally: check if error text mentions missing/invalid fields
        $text = strtolower($error->text());
        $this->assertTrue(
            strpos($text, 'required') !== false ||
            strpos($text, 'invalid') !== false ||
            strpos($text, 'missing') !== false,
            'Error message should indicate what needs to be corrected.'
        );
    }
}