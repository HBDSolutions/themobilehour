# Test 5.6 – Display Data (SELECT)

## User Story
As an application user  
I need to view data stored in the database  
So that I can see relevant information in the application interface

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.6.1: Application Executes SELECT Query Successfully
**Given** the database contains records  
**When** the application executes a SELECT query  
**Then** the expected data is retrieved and available for display

### Scenario 5.6.2: Retrieved Data is Accurately Displayed
**Given** the application has retrieved data from the database  
**When** the data is presented on the user interface  
**Then** all relevant fields are displayed accurately and match the database values

### Scenario 5.6.3: No Records Handling
**Given** the SELECT query returns no records  
**When** the application attempts to display data  
**Then** a clear “no data found” message is shown to the user

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|--------------------------------------------------------------------------|
| 5.6.1       | Test_5_6_DisplayDataSelect::test_5_6_1_ApplicationExecutesSelect         |
| 5.6.2       | Test_5_6_DisplayDataSelect::test_5_6_2_DataAccuratelyDisplayed          |
| 5.6.3       | Test_5_6_DisplayDataSelect::test_5_6_3_NoRecordsHandling                |