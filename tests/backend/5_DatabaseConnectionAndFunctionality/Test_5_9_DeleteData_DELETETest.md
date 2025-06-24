# Test 5.9 – Delete Data (DELETE)

## User Story
As an application user  
I need to delete data from the database  
So that I can remove information that is no longer needed through the application interface

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.9.1: Application Executes DELETE Query Successfully
**Given** there is an existing record in the database  
**When** the application executes a DELETE query  
**Then** the specified record is removed from the database

### Scenario 5.9.2: Deleted Data is No Longer Present
**Given** a record has been deleted via the application  
**When** the database is queried for the deleted record  
**Then** the deleted record is no longer found in the database

### Scenario 5.9.3: Invalid Delete is Handled Gracefully
**Given** the application attempts to delete a non-existent record or submits an invalid DELETE query  
**When** the DELETE query is executed  
**Then** the operation fails gracefully and an informative error or validation message is presented

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|--------------------------------------------------------------------------|
| 5.9.1       | Test_5_9_DeleteDataDelete::test_5_9_1_ApplicationExecutesDelete          |
| 5.9.2       | Test_5_9_DeleteDataDelete::test_5_9_2_DeletedDataNoLongerPresent         |
| 5.9.3       | Test_5_9_DeleteDataDelete::test_5_9_3_InvalidDeleteHandledGracefully     |