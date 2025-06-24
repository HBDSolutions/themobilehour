# Test 2.2 – Edit Account Contact and Shipping Data

## User Story
As a registered customer account user  
I need to edit my account contact and shipping data  
So that subsequent purchases can be managed accurately

---

## Acceptance Criteria / BDD Scenarios

### Scenario 2.2.1: Update Contact Information
**Given** a logged-in customer is on their account settings page  
**When** the customer edits and saves their contact information (name, email, phone, etc.)  
**Then**
- The new contact information is saved and displayed
- The customer receives visual confirmation of the update

### Scenario 2.2.2: Update Shipping Address
**Given** a logged-in customer is on their account settings page  
**When** the customer edits and saves their shipping address(es)  
**Then**
- The new shipping address is saved and displayed
- The customer receives confirmation of the update

### Scenario 2.2.3: Validation of Data
**Given** a customer enters invalid data (e.g., invalid email, incomplete address)  
**When** the customer tries to save the changes  
**Then**
- The system prevents saving invalid data
- The customer is shown clear validation error messages

### Scenario 2.2.4: Security of Changes
**Given** a customer updates their account data  
**When** the update is submitted  
**Then**
- Only the authenticated customer can make changes to their own account
- Data is transmitted securely

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                         |
|-------------|---------------------------------------------------------------|
| 2.2.1       | Test_2_2_EditAccountData::test_2_2_1_UpdateContactInformation |
| 2.2.2       | Test_2_2_EditAccountData::test_2_2_2_UpdateShippingAddress    |
| 2.2.3       | Test_2_2_EditAccountData::test_2_2_3_ValidationOfData         |
| 2.2.4       | Test_2_2_EditAccountData::test_2_2_4_SecurityOfChanges        |