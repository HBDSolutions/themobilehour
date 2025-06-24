# Test 3.8 – Change Log for Admin Users

## User Story
As an admin user  
I need a change log  
So that I know what updates have been made

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.8.1: View Change Log
**Given** an admin is logged into the admin area  
**When** the admin navigates to the change log page  
**Then**
- The admin sees a chronological list of updates (product, customer, settings, etc.)
- Each entry shows what was changed, who made the change, and when

### Scenario 3.8.2: Filter and Search Change Log
**Given** an admin is viewing the change log  
**When** the admin uses filter or search options (e.g., by date, user, type of change)  
**Then**
- The displayed entries match the selected filters or search terms

### Scenario 3.8.3: Change Log Entry Details
**Given** an admin clicks on a change log entry  
**When** the details are displayed  
**Then**
- The admin sees specific information about the change (fields, old/new values, affected records)

### Scenario 3.8.4: Access Control for Change Log
**Given** a non-admin or unauthorized user tries to access the change log  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

### Scenario 3.8.5: Change Log Integrity
**Given** a change is made to the system  
**When** the change occurs  
**Then**
- The change log entry is automatically created and cannot be modified or deleted by ordinary users

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                         |
|-------------|---------------------------------------------------------------|
| 3.8.1       | Test_3_8_ChangeLog::test_3_8_1_ViewChangeLog                  |
| 3.8.2       | Test_3_8_ChangeLog::test_3_8_2_FilterAndSearchChangeLog       |
| 3.8.3       | Test_3_8_ChangeLog::test_3_8_3_ChangeLogEntryDetails          |
| 3.8.4       | Test_3_8_ChangeLog::test_3_8_4_AccessControlForChangeLog      |
| 3.8.5       | Test_3_8_ChangeLog::test_3_8_5_ChangeLogIntegrity             |