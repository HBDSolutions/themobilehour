# Test 7.1 – Password Rules Validation

## User Story
As a user  
I want password requirements to be validated and clearly communicated  
So that I can create a secure, valid password for my account

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.1.1: Password Requirements are Clearly Displayed
**Given** I am on the registration or password change page  
**When** the page loads  
**Then** the password rules (e.g., length, character types) are clearly visible before I enter a password

### Scenario 7.1.2: Invalid Password is Rejected with Clear Messages
**Given** I enter a password that does not meet the requirements  
**When** I attempt to submit the form  
**Then** the form is not submitted and I receive a clear error message indicating which rules were not met

### Scenario 7.1.3: Valid Password is Accepted
**Given** I enter a password that meets all requirements  
**When** I submit the form  
**Then** the password is accepted and my registration or password change succeeds

---

## Traceability

| Scenario ID | Maps to Test Method                                                   |
|-------------|----------------------------------------------------------------------|
| 7.1.1       | Test_7_1_PasswordRulesValidation::test_7_1_1_PasswordRulesVisible    |
| 7.1.2       | Test_7_1_PasswordRulesValidation::test_7_1_2_InvalidPasswordRejected |
| 7.1.3       | Test_7_1_PasswordRulesValidation::test_7_1_3_ValidPasswordAccepted   |