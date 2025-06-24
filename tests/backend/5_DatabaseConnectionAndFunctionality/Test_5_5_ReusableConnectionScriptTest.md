# Test 5.5 – Reusable Database Connection Script

## User Story
As a system administrator  
I need a reusable database connection script that uses the web application connection user account  
So that application code can connect securely and consistently to the database

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.5.1: Connection Script Exists and Uses Web User Credentials
**Given** the web user account credentials are available  
**When** I review the database connection script  
**Then** the script uses the correct web user account credentials (not root or admin accounts)

### Scenario 5.5.2: Script Allows Successful Application Connection
**Given** the connection script is included in application code  
**When** the application calls the script to connect to the database  
**Then** the database connection is established successfully using the web user account

### Scenario 5.5.3: Script is Reusable and Modular
**Given** the connection script is used in multiple parts of the application  
**When** different components require database access  
**Then** they can all include or require the same connection script without code duplication

### Scenario 5.5.4: Script Handles Connection Errors Gracefully
**Given** the connection script is used  
**When** a connection attempt fails (e.g., wrong credentials, database not available)  
**Then** the script handles the error gracefully and returns or logs an informative error

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                           |
|-------------|----------------------------------------------------------------------------------|
| 5.5.1       | Test_5_5_ReusableConnectionScript::test_5_5_1_ConnectionScriptUsesWebUser        |
| 5.5.2       | Test_5_5_ReusableConnectionScript::test_5_5_2_ScriptAllowsSuccessfulConnection   |
| 5.5.3       | Test_5_5_ReusableConnectionScript::test_5_5_3_ScriptIsReusableAndModular         |
| 5.5.4       | Test_5_5_ReusableConnectionScript::test_5_5_4_ScriptHandlesConnectionErrors      |