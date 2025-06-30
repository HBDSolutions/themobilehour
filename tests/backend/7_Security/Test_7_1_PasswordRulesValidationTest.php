<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 7.1 – Password Rules Validation
 *
 * User Story:
 * As a user
 * I want password requirements to be validated and clearly communicated
 * So that I can create a secure, valid password for my account
 *
 * Acceptance Criteria / BDD Scenarios:
 * 7.1.1 – Password Requirements are Clearly Displayed
 * 7.1.2 – Invalid Password is Rejected with Clear Messages
 * 7.1.3 – Valid Password is Accepted
 */
class Test_7_1_PasswordRulesValidationTest extends TestCase
{
    /**
     * 7.1.1 – Password Requirements are Clearly Displayed
     * Given I am on the registration or password change page
     * When the page loads
     * Then the password rules (e.g., length, character types) are clearly visible before I enter a password
     */
    public function test_7_1_1_PasswordRulesVisible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $urls = [
            'http://localhost/register',
            'http://localhost/password/change'
        ];
        foreach ($urls as $url) {
            $crawler = $client->request('GET', $url);

            // Look for a password rules message
            $rules = $crawler->filter('.password-rules, .password-requirements, #password-rules');
            $this->assertGreaterThan(
                0,
                $rules->count(),
                "Password rules should be visible on $url."
            );
            $rulesText = $rules->text();
            $this->assertNotEmpty($rulesText, "Password rules text should be present on $url.");
            // Optionally: check for at least two requirements (length, character type, etc)
            $this->assertTrue(
                preg_match('/[Ll]ength|[Mm]inimum|[Uu]pper|[Ll]ower|[Nn]umber|[Ss]pecial/', $rulesText) === 1,
                "Password rules should mention at least one requirement on $url."
            );
        }
    }

    /**
     * 7.1.2 – Invalid Password is Rejected with Clear Messages
     * Given I enter a password that does not meet the requirements
     * When I attempt to submit the form
     * Then the form is not submitted and I receive a clear error message indicating which rules were not met
     */
    public function test_7_1_2_InvalidPasswordRejected()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/register');

        $form = $crawler->selectButton('Register')->form();
        $unique = 'user' . uniqid();
        $form['username'] = $unique;
        $form['email'] = "$unique@example.com";
        $form['password'] = 'abc'; // obviously invalid
        if (isset($form['confirm_password'])) {
            $form['confirm_password'] = 'abc';
        }
        if (isset($form['password_confirmation'])) {
            $form['password_confirmation'] = 'abc';
        }
        $client->submit($form);

        // Wait for error message
        $client->waitFor('.alert-danger, .error-message, .form-error, .password-error', 3);

        $error = $client->getCrawler()->filter('.alert-danger, .error-message, .form-error, .password-error');
        $this->assertGreaterThan(0, $error->count(), 'Clear error message should be shown for invalid password.');

        // Check that error message mentions a rule (length, character, etc)
        $text = strtolower($error->text());
        $this->assertTrue(
            strpos($text, 'length') !== false ||
            strpos($text, 'character') !== false ||
            strpos($text, 'uppercase') !== false ||
            strpos($text, 'lowercase') !== false ||
            strpos($text, 'number') !== false ||
            strpos($text, 'special') !== false,
            'Error message should indicate which password rule was not met.'
        );
    }

    /**
     * 7.1.3 – Valid Password is Accepted
     * Given I enter a password that meets all requirements
     * When I submit the form
     * Then the password is accepted and my registration or password change succeeds
     */
    public function test_7_1_3_ValidPasswordAccepted()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/register');

        $form = $crawler->selectButton('Register')->form();
        $unique = 'user' . uniqid();
        $validPassword = 'ValidPass1!';
        $form['username'] = $unique;
        $form['email'] = "$unique@example.com";
        $form['password'] = $validPassword;
        if (isset($form['confirm_password'])) {
            $form['confirm_password'] = $validPassword;
        }
        if (isset($form['password_confirmation'])) {
            $form['password_confirmation'] = $validPassword;
        }
        $client->submit($form);

        // Wait for registration success
        $client->waitFor('.alert-success, .registration-success, .welcome-message, .dashboard, .home', 5);

        // Check for success indication
        $success = $client->getCrawler()->filter('.alert-success, .registration-success, .welcome-message')->count() > 0 ||
                   strpos($client->getCurrentURL(), '/dashboard') !== false ||
                   strpos($client->getCurrentURL(), '/home') !== false;
        $this->assertTrue($success, 'Should be logged in or shown a registration success message after valid password.');
    }
}