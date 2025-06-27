<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.3 – Web Connection User Account Creation
 *
 * User Story:
 * As a system administrator
 * I need a dedicated user account for the web application to connect to the database
 * So that I can securely manage application access to the DBMS
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.3.2 – Web User Account Has Application-Appropriate Privileges
 * 5.3.3 – Application Can Connect Using Web User Account
 */
class Test_5_3_WebUserAccountCreatedTest extends TestCase
{
    /*
    * 5.3.2 – Web User Account Has Application-Appropriate Privileges
    * Given the web application user account exists  
    * When I review the privileges assigned to the user  
    * Then
    * - the user has only the minimum necessary privileges to read/write data as required by the application
    */
    public function test_5_3_2_WebUserAccountHasApplicationAppropriatePrivileges()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.3.3 – Application Can Connect Using Web User Account
    * Given the web application is configured to use the web user account  
    * When the application attempts to connect to the database  
    * Then
    * - the connection is successful using the web user account credentials
    */
    public function test_5_3_3_ApplicationCanConnectUsingWebUserAccount()
    {
        // TODO: Implement test logic for this scenario.
    }

}
