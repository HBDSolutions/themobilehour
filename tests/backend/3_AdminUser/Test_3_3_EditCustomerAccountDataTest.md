# Test 3.3 – Edit Customer Account Data

## User Story
As an admin user  
I need to edit customer account data  
So that I can support customers with updates and password resets

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.3.1: Update Customer Contact Information
**Given** an admin is logged into the admin area  
**When** the admin updates a customer's contact information (name, email, phone, etc.)  
**Then**
- The updated information is saved and displayed in the customer’s account
- The admin receives confirmation of the update

### Scenario 3.3.2: Update Customer Shipping Address
**Given** an admin is logged into the admin area  
**When** the admin updates a customer's shipping address  
**Then**
- The new shipping address is saved and displayed
- The admin receives confirmation of the update

### Scenario 3.3.3: Admin-Initiated Password Reset
**Given** an admin is logged into the admin area  
**When** the admin initiates a password reset for a customer  
**Then**
- The customer receives a password reset email or secure notification
- The reset process follows security best practices

### Scenario 3.3.4: Validation of Edited Data
**Given** an admin attempts to save invalid data for a customer (e.g., invalid email, incomplete address)  
**When** the admin submits the changes  
**Then**
- The system prevents saving invalid data
- The admin is shown clear validation error messages

### Scenario 3.3.5: Audit Trail for Changes
**Given** an admin modifies customer account data  
**When** the changes are saved  
**Then**
- An audit log records the admin’s identity, the changes made, and the timestamp

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                  |
|-------------|------------------------------------------------------------------------|
| 3.3.1       | Test_3_3_EditCustomerAccountData::test_3_3_1_UpdateCustomerContactInfo |
| 3.3.2       | Test_3_3_EditCustomerAccountData::test_3_3_2_UpdateCustomerShipping    |
| 3.3.3       | Test_3_3_EditCustomerAccountData::test_3_3_3_AdminInitiatedPwdReset    |
| 3.3.4       | Test_3_3_EditCustomerAccountData::test_3_3_4_ValidationOfEditedData    |
| 3.3.5       | Test_3_3_EditCustomerAccountData::test_3_3_5_AuditTrailForChanges      |