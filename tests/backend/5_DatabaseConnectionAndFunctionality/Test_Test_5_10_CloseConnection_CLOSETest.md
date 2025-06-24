# Test 5.10 – Close the Connection (CLOSE)

## User Story
As an application developer  
I want to ensure that database connections are properly closed after use  
So that I can prevent resource leaks and improve application stability

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.10.1: Application Closes Connection After Use
**Given** the application has finished using the database  
**When** the database operation is complete  
**Then** the connection to the database is closed

### Scenario 5.10.2: Attempting to Use Closed Connection Fails Gracefully
**Given** the connection has been closed  
**When** the application attempts to use the closed connection  
**Then** an informative error or exception is returned, and no database operation is performed

### Scenario 5.10.3: No Resource Leaks After Connection Close
**Given** multiple connections have been opened and closed  
**When** the application is monitored for resource usage  
**Then** there are no lingering open connections or resource leaks

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                    |
|-------------|---------------------------------------------------------------------------|
| 5.10.1      | Test_5_10_CloseConnectionClose::test_5_10_1_ApplicationClosesConnection   |
| 5.10.2      | Test_5_10_CloseConnectionClose::test_5_10_2_AttemptUseClosedFailsGraceful |
| 5.10.3      | Test_5_10_CloseConnectionClose::test_5_10_3_NoResourceLeaksAfterClose     |