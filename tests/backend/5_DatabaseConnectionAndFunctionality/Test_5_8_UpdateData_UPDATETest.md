# Test 5.8 – Update Data (UPDATE)

## User Story
As an application user  
I need to update existing data in the database  
So that I can correct or modify information through the application interface

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.8.1: Application Executes UPDATE Query Successfully
**Given** there is an existing record in the database  
**When** the application executes an UPDATE query with new data  
**Then** the record is updated with the new values

### Scenario 5.8.2: Updated Data is Accurately Stored
**Given** the application has executed an UPDATE query  
**When** the database is queried for the updated record  
**Then** all updated fields match the new input data

### Scenario 5.8.3: Invalid Update is Handled Gracefully
**Given** the application attempts to update with invalid data  
**When** the UPDATE query is executed  
**Then** the update fails gracefully and an informative error or validation message is presented

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|--------------------------------------------------------------------------|
| 5.8.1       | Test_5_8_UpdateDataUpdate::test_5_8_1_ApplicationExecutesUpdate          |
| 5.8.2       | Test_5_8_UpdateDataUpdate::test_5_8_2_UpdatedDataAccuratelyStored        |
| 5.8.3       | Test_5_8_UpdateDataUpdate::test_5_8_3_InvalidUpdateHandledGracefully     |