<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.8 – Update Data (UPDATE)
 *
 * User Story:
 * As an application user
 * I need to update existing data in the database
 * So that I can correct or modify information through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.8.2 – Updated Data is Accurately Stored
 * 5.8.3 – Invalid Update is Handled Gracefully
 */
class Test_5_8_UpdateData_UPDATETest extends TestCase
{
    /*
    * 5.8.2 – Updated Data is Accurately Stored
    * Given the application has executed an UPDATE query  
    * When the database is queried for the updated record  
    * Then
    * - all updated fields match the new input data
    */
    public function test_5_8_2_UpdatedDataisAccuratelyStored()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.8.3 – Invalid Update is Handled Gracefully
    * Given the application attempts to update with invalid data  
    * When the UPDATE query is executed  
    * Then
    * - the update fails gracefully and an informative error or validation message is presented
    */
    public function test_5_8_3_InvalidUpdateisHandledGracefully()
    {
        // TODO: Implement test logic for this scenario.
    }

}
