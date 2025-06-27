<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.7 – Insert Data (INSERT)
 *
 * User Story:
 * As an application user
 * I need to add new data to the database
 * So that I can store new information through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.7.2 – Inserted Data is Accurately Stored
 * 5.7.3 – Invalid Data is Handled Gracefully
 */
class Test_5_7_InsertData_INSERTTest extends TestCase
{
    /*
    * 5.7.2 – Inserted Data is Accurately Stored
    * Given the application has executed an INSERT query  
    * When the database is queried for the new data  
    * Then
    * - all fields of the new record match the input data
    */
    public function test_5_7_2_InsertedDataisAccuratelyStored()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.7.3 – Invalid Data is Handled Gracefully
    * Given the application receives invalid or incomplete input  
    * When the application attempts to execute an INSERT query  
    * Then
    * - the insert fails gracefully and an informative error or validation message is presented
    */
    public function test_5_7_3_InvalidDataisHandledGracefully()
    {
        // TODO: Implement test logic for this scenario.
    }

}
