<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.4 – Database Created and Available
 *
 * User Story:
 * As a developer,
 * I need the application database to be created and available,
 * So that the application can store and retrieve data reliably.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.4.1 – Database Exists
 * 5.4.2 – Database Schema is Present
 * 5.4.3 – Database Is Accessible
 */
class Test_5_4_DatabaseCreatedAndAvailableTest extends TestCase
{
    /*
    * 5.4.1 – Database Exists
    * Given MySQL is running
    * When I check the list of databases
    * Then
    * - the application database (e.g., `app_db`) is present
    */
    public function test_5_4_1_DatabaseExists()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.4.2 – Database Schema is Present
    * Given the application database exists
    * When I inspect its tables
    * Then
    * - all required tables and columns (according to the application schema) are present
    */
    public function test_5_4_2_DatabaseSchemaIsPresent()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.4.3 – Database Is Accessible
    * Given the application is configured to connect to the database
    * When the application attempts to query the database
    * Then
    * - queries succeed and no access errors occur
    */
    public function test_5_4_3_DatabaseIsAccessible()
    {
        // TODO: Implement test logic for this scenario.
    }
}