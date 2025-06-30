<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 7.4 – Session Management
 *
 * User Story:
 * As a user
 * I want my session to be managed securely and conveniently
 * So that I stay logged in when expected and my account remains safe
 *
 * Acceptance Criteria / BDD Scenarios:
 * 7.4.1 – Session is Created Upon Login
 * 7.4.2 – Session Expires After Inactivity or Logout
 * 7.4.3 – Session Cookie is Secure and HttpOnly
 * 7.4.4 – Session is Invalidated After Password Change
 */
class Test_7_4_SessionManagementTest extends TestCase
{
    /**
     * 7.4.1 – Session is Created Upon Login
     * Given I log in with valid credentials
     * When authentication is successful
     * Then a secure session is created and maintained for my account
     */
    public function test_7_4_1_SessionCreatedOnLogin()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $password = 'SessionTestPass1!';
        $this->createTestUser($username, $email, $password);

        $crawler = $client->request('GET', 'http://localhost/login');
        $form = $crawler->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);

        $client->waitFor('.dashboard, .home, .user-profile, .alert-success', 5);

        // Assert session cookie is set
        $cookies = $client->getCookieJar()->all();
        $sessionCookie = array_filter($cookies, function ($cookie) {
            return stripos($cookie->getName(), 'sess') !== false;
        });
        $this->assertNotEmpty($sessionCookie, 'Session cookie should be set after login.');
    }

    /**
     * 7.4.2 – Session Expires After Inactivity or Logout
     * Given I am logged in
     * When I log out or am inactive for a configured period
     * Then my session is terminated and I am required to log in again
     */
    public function test_7_4_2_SessionExpiresOrLogout()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $password = 'SessionExpire1!';
        $this->createTestUser($username, $email, $password);

        $crawler = $client->request('GET', 'http://localhost/login');
        $form = $crawler->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);
        $client->waitFor('.dashboard, .home, .user-profile, .alert-success', 5);

        // Logout (try to find a logout link or post)
        $logoutLink = $client->getCrawler()->selectLink('Logout');
        if ($logoutLink->count() > 0) {
            $logoutLink->click();
        } else {
            // Try common logout URLs
            $client->request('GET', 'http://localhost/logout');
        }

        // After logout, session cookie may be deleted or invalid
        $client->request('GET', 'http://localhost/dashboard');
        $this->assertTrue(
            $client->getCrawler()->filter('.login-form, .alert-danger, .login-page')->count() > 0 ||
            strpos($client->getCurrentURL(), '/login') !== false,
            'After logout, user should be required to log in again.'
        );

        // Inactivity test (simulate by clearing cookies)
        $client->getCookieJar()->clear();
        $client->request('GET', 'http://localhost/dashboard');
        $this->assertTrue(
            $client->getCrawler()->filter('.login-form, .alert-danger, .login-page')->count() > 0 ||
            strpos($client->getCurrentURL(), '/login') !== false,
            'After inactivity/session clear, user should be required to log in again.'
        );
    }

    /**
     * 7.4.3 – Session Cookie is Secure and HttpOnly
     * Given I am logged in
     * When my session cookie is set
     * Then it has the Secure and HttpOnly flags enabled
     */
    public function test_7_4_3_SessionCookieSecureHttpOnly()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $password = 'SessionCookie1!';
        $this->createTestUser($username, $email, $password);

        $crawler = $client->request('GET', 'http://localhost/login');
        $form = $crawler->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);

        $client->waitFor('.dashboard, .home, .user-profile, .alert-success', 5);

        // Assert session cookie is set and has Secure and HttpOnly
        $cookies = $client->getCookieJar()->all();
        $sessionCookies = array_filter($cookies, function ($cookie) {
            return stripos($cookie->getName(), 'sess') !== false;
        });
        $this->assertNotEmpty($sessionCookies, 'Session cookie should be set after login.');
        foreach ($sessionCookies as $cookie) {
            $this->assertTrue(
                $cookie->isHttpOnly(),
                'Session cookie should have HttpOnly flag.'
            );
            // Secure flag should be set if running over HTTPS (skip if test env is HTTP)
            if (strpos($cookie->getDomain(), 'localhost') === false || $_SERVER['HTTPS'] ?? false) {
                $this->assertTrue(
                    $cookie->isSecure(),
                    'Session cookie should have Secure flag when using HTTPS.'
                );
            }
        }
    }

    /**
     * 7.4.4 – Session is Invalidated After Password Change
     * Given I change my password
     * When the password change is completed
     * Then all existing sessions are invalidated and I must log in again
     */
    public function test_7_4_4_SessionInvalidatedOnPwChange()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $oldPassword = 'SessionOldPW1!';
        $newPassword = 'SessionNewPW1!';
        $this->createTestUser($username, $email, $oldPassword);

        // Login
        $crawler = $client->request('GET', 'http://localhost/login');
        $form = $crawler->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $oldPassword;
        $client->submit($form);
        $client->waitFor('.dashboard, .home, .user-profile, .alert-success', 5);

        // Change password
        $crawler = $client->request('GET', 'http://localhost/password/change');
        $form = $crawler->selectButton('Change Password')->form();
        $form['current_password'] = $oldPassword;
        $form['new_password'] = $newPassword;
        if (isset($form['confirm_password'])) {
            $form['confirm_password'] = $newPassword;
        }
        $client->submit($form);

        $client->waitFor('.alert-success, .password-changed, .login-form', 5);

        // Try to access dashboard/profile with old session
        $client->request('GET', 'http://localhost/dashboard');
        $this->assertTrue(
            $client->getCrawler()->filter('.login-form, .alert-danger, .login-page')->count() > 0 ||
            strpos($client->getCurrentURL(), '/login') !== false,
            'After password change, old session should be invalidated and require login again.'
        );
    }

    /**
     * Helper: Create a test user with a specified password.
     */
    protected function createTestUser($username, $email, $password)
    {
        $pdo = $this->getPDO();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)")
            ->execute([$username, $email, $hash, 'user']);
    }

    /**
     * Helper: Returns a PDO instance for direct DB access.
     * Adjust connection details for your test database.
     */
    protected function getPDO()
    {
        static $pdo = null;
        if (!$pdo) {
            $pdo = new \PDO('mysql:host=localhost;dbname=test_db', 'test_user', 'test_password');
        }
        return $pdo;
    }
}