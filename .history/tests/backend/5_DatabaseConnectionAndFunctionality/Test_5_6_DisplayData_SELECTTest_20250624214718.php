<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.6 – Display Data (SELECT)
 *
 * User Story:
 * As an application user
 * I need to view data stored in the database
 * So that I can see relevant information in the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.6.2 – Retrieved Data is Accurately Displayed
 * 5.6.3 – No Records Handling
 */
class Test_5_6_DisplayData_SELECTTest extends TestCase
{
    /*
    * 5.6.2 – Retrieved Data is Accurately Displayed
    * Given the application has retrieved data from the database  
    * When the data is presented on the user interface  
    * Then
    * - all relevant fields are displayed accurately and match the database values
    */
    public function test_5_6_2_RetrievedDataisAccuratelyDisplayed()
    {
        // TODO: Implement test logic for this scenario.
    }

    /*
    * 5.6.3 – No Records Handling
    * Given the SELECT query returns no records  
    * When the application attempts to display data  
    * Then
    * - a clear “no data found” message is shown to the user
    */
    public function test_5_6_3_NoRecordsHandling()
    {
        // TODO: Implement test logic for this scenario.
    }

}
