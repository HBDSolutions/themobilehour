# Test 4.2 – Edit Admin User Accounts

## User Story
As an admin manager  
I need to edit admin user accounts  
So that I can update admin roles and permissions

---

## Acceptance Criteria / BDD Scenarios

### Scenario 4.2.1: Successful Admin User Account Edit
**Given** an admin manager is logged into the admin management area  
**When** the admin manager updates an admin user's details (role, permissions, etc.) with valid data and submits  
**Then**
- The admin user's updated details are saved in the system
- The admin manager receives confirmation of the update

### Scenario 4.2.2: Validation Errors on Edit
**Given** an admin manager is editing an admin user account  
**When** invalid or incomplete data is submitted (e.g., invalid role, empty required fields)  
**Then**
- The system prevents the update
- The admin manager is shown clear validation error messages

### Scenario 4.2.3: Audit Log for Admin Account Edits
**Given** an admin manager edits an admin user account  
**When** the update is saved  
**Then**
- An audit log records the admin manager’s identity, the changes made, the affected admin account, and the timestamp

### Scenario 4.2.4: Access Control for Editing Admin Users
**Given** a non-manager or unauthorized user tries to edit an admin user account  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                    |
|-------------|--------------------------------------------------------------------------|
| 4.2.1       | Test_4_2_EditAdminUserAccount::test_4_2_1_SuccessfulAdminUserAccountEdit |
| 4.2.2       | Test_4_2_EditAdminUserAccount::test_4_2_2_ValidationErrorsOnEdit         |
| 4.2.3       | Test_4_2_EditAdminUserAccount::test_4_2_3_AuditLogForAdminAccountEdits   |
| 4.2.4       | Test_4_2_EditAdminUserAccount::test_4_2_4_AccessControlForEditingAdminUsers |