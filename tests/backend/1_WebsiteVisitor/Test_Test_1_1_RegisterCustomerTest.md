# Test 1.1 – Customer Account Registration

## User Story
As a website visitor  
I need to create and register a customer account  
So that I can use saved data to buy, track and view history

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.1.1: Successful Account Registration
**Given** a website visitor is on the registration page  
**When** the visitor submits valid registration details (e.g., name, email, password, and any required fields)  
**Then**  
- A new customer account is created  
- The user is informed of successful registration  
- The user is logged in and redirected to their account/dashboard page

### Scenario 1.1.2: Duplicate Email Registration
**Given** a website visitor attempts to register using an email address already associated with an existing account  
**When** the visitor submits the registration form  
**Then**  
- Registration fails  
- The user is shown a clear error message indicating the email is already in use

### Scenario 1.1.3: Missing Required Fields
**Given** a website visitor is on the registration page  
**When** the visitor submits the form with one or more required fields left blank  
**Then**  
- Registration fails  
- The user is shown errors indicating which fields are missing or invalid

### Scenario 1.1.4: Password Validation
**Given** a website visitor is on the registration page  
**When** the visitor submits a password that does not meet complexity requirements (e.g., too short, lacks numbers/special characters)  
**Then**  
- Registration fails  
- The user receives an error message describing the password requirements

### Scenario 1.1.5: View Account Data After Registration
**Given** a user has successfully registered and is logged in  
**When** the user navigates to their account page  
**Then**  
- The user can view their account details  
- The user can access options to buy, track orders, and view order history

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                      |
|-------------|------------------------------------------------------------|
| 1.1.1       | Test_1_1_RegisterCustomer::test_1_1_1_SuccessfulRegistration |
| 1.1.2       | Test_1_1_RegisterCustomer::test_1_1_2_DuplicateEmailRegistration |
| 1.1.3       | Test_1_1_RegisterCustomer::test_1_1_3_MissingRequiredFields |
| 1.1.4       | Test_1_1_RegisterCustomer::test_1_1_4_PasswordValidation     |
| 1.1.5       | Test_1_1_RegisterCustomer::test_1_1_5_ViewAccountDataAfterRegistration |