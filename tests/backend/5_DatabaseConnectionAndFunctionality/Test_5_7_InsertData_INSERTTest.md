# Test 5.7 – Insert Data (INSERT)

## User Story
As an application user  
I need to add new data to the database  
So that I can store new information through the application interface

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.7.1: Application Executes INSERT Query Successfully
**Given** the application receives new data from a user input  
**When** the application executes an INSERT query  
**Then** the new record is added to the correct table in the database

### Scenario 5.7.2: Inserted Data is Accurately Stored
**Given** the application has executed an INSERT query  
**When** the database is queried for the new data  
**Then** all fields of the new record match the input data

### Scenario 5.7.3: Invalid Data is Handled Gracefully
**Given** the application receives invalid or incomplete input  
**When** the application attempts to execute an INSERT query  
**Then** the insert fails gracefully and an informative error or validation message is presented

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|--------------------------------------------------------------------------|
| 5.7.1       | Test_5_7_InsertDataInsert::test_5_7_1_ApplicationExecutesInsert          |
| 5.7.2       | Test_5_7_InsertDataInsert::test_5_7_2_InsertedDataAccuratelyStored       |
| 5.7.3       | Test_5_7_InsertDataInsert::test_5_7_3_InvalidDataHandledGracefully       |