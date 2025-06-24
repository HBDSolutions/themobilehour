# Test 7.4 – Session Management

## User Story
As a user  
I want my session to be managed securely and conveniently  
So that I stay logged in when expected and my account remains safe

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.4.1: Session is Created Upon Login
**Given** I log in with valid credentials  
**When** authentication is successful  
**Then** a secure session is created and maintained for my account

### Scenario 7.4.2: Session Expires After Inactivity or Logout
**Given** I am logged in  
**When** I log out or am inactive for a configured period  
**Then** my session is terminated and I am required to log in again

### Scenario 7.4.3: Session Cookie is Secure and HttpOnly
**Given** I am logged in  
**When** my session cookie is set  
**Then** it has the Secure and HttpOnly flags enabled

### Scenario 7.4.4: Session is Invalidated After Password Change
**Given** I change my password  
**When** the password change is completed  
**Then** all existing sessions are invalidated and I must log in again

---

## Traceability

| Scenario ID | Maps to Test Method                                                   |
|-------------|----------------------------------------------------------------------|
| 7.4.1       | Test_7_4_SessionManagement::test_7_4_1_SessionCreatedOnLogin         |
| 7.4.2       | Test_7_4_SessionManagement::test_7_4_2_SessionExpiresOrLogout        |
| 7.4.3       | Test_7_4_SessionManagement::test_7_4_3_SessionCookieSecureHttpOnly   |
| 7.4.4       | Test_7_4_SessionManagement::test_7_4_4_SessionInvalidatedOnPwChange  |