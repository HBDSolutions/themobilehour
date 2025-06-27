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
        $username = 'stduser_' . uniqid();
        $this->createTestUser($username, "$username@example.com", 'StdUserPass123!', 'user');

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $this->loginAs($client, $username, 'StdUserPass123!');

        $crawler = $client->request('GET', 'http://localhost/admin');
        $error = $crawler->filter('.alert-danger, .error-message