<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 7.3 – Role-Based Permissions
 *
 * User Story:
 * As an application user or administrator
 * I want permissions and access to be based on user roles
 * So that only authorized users can access restricted features or data
 *
 * Acceptance Criteria / BDD Scenarios:
 * 7.3.1 – User with Standard Role Cannot Access Admin Features
 * 7.3.2 – Admin Can Access Admin Features
 * 7.3.3 – Role Changes Take Effect Immediately
 */
class Test_7_3_RoleBasedPermissionsTest extends TestCase
{
    /**
     * 7.3.1 – User with Standard Role Cannot Access Admin Features
     * Given I am logged in as a user with a standard role
     * When I try to access admin-only features or pages
     * Then I am denied access and shown an appropriate error or redirect
     */
    public function test_7_3_1_StandardUserDeniedAdmin()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();

        // Create and login as standard user
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $password = 'UserTestPass1!';
        $this->createTestUser($username, $email, $password, 'user');

        // Login
        $client->request('GET', 'http://localhost/login');
        $form = $client->getCrawler()->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);

        // Try to access admin page
        $crawler = $client->request('GET', 'http://localhost/admin');
        // Expect error/forbidden or redirect (usually 403, 401, or redirect to /login or /)
        $error = $crawler->filter('.alert-danger, .error-message, .forbidden, .unauthorized');
        $this->assertTrue(
            $error->count() > 0 ||
            strpos($client->getCurrentURL(), '/login') !== false ||
            strpos($client->getCurrentURL(), '/') === 0, // redirect to home
            "Standard user should be denied access to admin features."
        );
    }

    /**
     * 7.3.2 – Admin Can Access Admin Features
     * Given I am logged in as an admin
     * When I access admin-only features or pages
     * Then I am granted access
     */
    public function test_7_3_2_AdminCanAccessAdmin()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();

        // Create and login as admin user
        $username = 'admin' . uniqid();
        $email = "$username@example.com";
        $password = 'AdminTestPass1!';
        $this->createTestUser($username, $email, $password, 'admin');

        // Login
        $client->request('GET', 'http://localhost/login');
        $form = $client->getCrawler()->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);

        // Access admin page
        $crawler = $client->request('GET', 'http://localhost/admin');
        // Look for admin dashboard or admin features
        $adminFeatures = $crawler->filter('.admin-dashboard, .admin-panel, .admin-content, h1:contains("Admin")');
        $this->assertGreaterThan(
            0,
            $adminFeatures->count(),
            "Admin user should be able to access admin features."
        );
    }

    /**
     * 7.3.3 – Role Changes Take Effect Immediately
     * Given my role is changed (e.g., from user to admin)
     * When I refresh or navigate the app
     * Then my new permissions are immediately applied
     */
    public function test_7_3_3_RoleChangeTakesEffect()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();

        // Create and login as standard user
        $username = 'user' . uniqid();
        $email = "$username@example.com";
        $password = 'RoleChangePass1!';
        $this->createTestUser($username, $email, $password, 'user');

        // Login
        $client->request('GET', 'http://localhost/login');
        $form = $client->getCrawler()->selectButton('Login')->form();
        $form['username'] = $username;
        $form['password'] = $password;
        $client->submit($form);

        // Confirm denied to admin
        $crawler = $client->request('GET', 'http://localhost/admin');
        $error = $crawler->filter('.alert-danger, .error-message, .forbidden, .unauthorized');
        $this->assertTrue(
            $error->count() > 0 ||
            strpos($client->getCurrentURL(), '/login') !== false,
            "Standard user should be denied access before role change."
        );

        // Change role in DB
        $this->setUserRole($username, 'admin');

        // Refresh and try again
        $crawler = $client->request('GET', 'http://localhost/admin');
        $adminFeatures = $crawler->filter('.admin-dashboard, .admin-panel, .admin-content, h1:contains("Admin")');
        $this->assertGreaterThan(
            0,
            $adminFeatures->count(),
            "User should be able to access admin features immediately after role change."
        );
    }

    /**
     * Helper: Create a test user with a specified role.
     */
    protected function createTestUser($username, $email, $password, $role)
    {
        $pdo = $this->getPDO();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)")
            ->execute([$username, $email, $hash, $role]);
    }

    /**
     * Helper: Change user role directly in DB.
     */
    protected function setUserRole($username, $role)
    {
        $pdo = $this->getPDO();
        $pdo->prepare("UPDATE users SET role = ? WHERE username = ?")
            ->execute([$role, $username]);
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