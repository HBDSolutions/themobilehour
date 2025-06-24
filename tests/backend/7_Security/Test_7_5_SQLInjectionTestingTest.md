# Test 7.5 – SQL Injection Testing

## User Story
As a security-conscious application owner  
I want to ensure inputs are protected against SQL injection  
So that my application and user data remain secure

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.5.1: SQL Injection Attempts Are Blocked on Login
**Given** a user attempts to log in  
**When** the username or password includes SQL injection code (e.g., ' OR '1'='1)  
**Then** the login attempt fails and no unauthorized access is granted

### Scenario 7.5.2: SQL Injection Attempts Are Blocked on Registration
**Given** a user attempts to register  
**When** the username, email, or other fields include SQL injection code  
**Then** the registration attempt fails and no malicious data is stored

### Scenario 7.5.3: SQL Injection Attempts Are Blocked on Profile Update
**Given** a logged-in user updates their profile  
**When** any input field contains SQL injection code  
**Then** the update fails and no malicious data is stored

---

## Traceability

| Scenario ID | Maps to Test Method                                           |
|-------------|--------------------------------------------------------------|
| 7.5.1       | Test_7_5_SQLInjectionTesting::test_7_5_1_LoginSQLInjection   |
| 7.5.2       | Test_7_5_SQLInjectionTesting::test_7_5_2_RegisterSQLInjection|
| 7.5.3       | Test_7_5_SQLInjectionTesting::test_7_5_3_ProfileSQLInjection |