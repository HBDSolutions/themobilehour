<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.9 – Delete Data (DELETE)
 *
 * User Story:
 * As an application user
 * I need to delete data from the database
 * So that I can remove information that is no longer needed through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.9.2 – Deleted Data is No Longer Present
 * 5.9.3 – Invalid Delete is Handled Gracefully
 */
class Test_5_9_DeleteData_DELETETest extends TestCase
{
    /*
    * 5.9.2 – Deleted Data is No Longer Present
    * Given a record has been deleted via the application  
    * When the database is queried for the deleted record  
    * Then
    * - the deleted record is no longer found in the database
    */
    public function test_5_9_2_DeletedDataisNoLongerPresent()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.9.3 – Invalid Delete is Handled Gracefully
    * Given the application attempts to delete a non-existent record or submits an invalid DELETE query  
    * When the DELETE query is executed  
    * Then
    * - the operation fails gracefully and an informative error or validation message is presented
    */
    public function test_5_9_3_InvalidDeleteisHandledGracefully()
    {
        // TODO: Implement test logic for this scenario.
    }

}
