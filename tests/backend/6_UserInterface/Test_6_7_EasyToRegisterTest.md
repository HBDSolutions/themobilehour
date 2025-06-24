# Test 6.7 – Easy to Register

## User Story
As a new user  
I want to easily register for an account  
So that I can start using the application without unnecessary friction

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.7.1: Registration Option is Prominently Visible
**Given** I am on the home page or login page  
**When** the page loads  
**Then** there is a clearly visible option to register or sign up

### Scenario 6.7.2: Registration Form is Simple and Clear
**Given** I have chosen to register  
**When** the registration form is displayed  
**Then** the form is concise, requests only essential information, and is easy to understand

### Scenario 6.7.3: User Can Register Successfully
**Given** I have filled out the registration form with valid information  
**When** I submit the form  
**Then** my account is created and I am logged in or shown a success message

### Scenario 6.7.4: Errors are Clear for Invalid Registration
**Given** I submit the registration form with missing or invalid information  
**When** the form is processed  
**Then** I receive a clear, specific error message indicating what needs to be corrected

---

## Traceability

| Scenario ID | Maps to Test Method                                                 |
|-------------|---------------------------------------------------------------------|
| 6.7.1       | Test_6_7_EasyToRegister::test_6_7_1_RegistrationOptionVisible       |
| 6.7.2       | Test_6_7_EasyToRegister::test_6_7_2_RegistrationFormSimple          |
| 6.7.3       | Test_6_7_EasyToRegister::test_6_7_3_UserCanRegister                 |
| 6.7.4       | Test_6_7_EasyToRegister::test_6_7_4_RegistrationErrorsClear         |