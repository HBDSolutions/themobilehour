# Test 1.8 – High Availability of Website

## User Story
As a website visitor  
I need high availability of the website to users  
So that I experience smooth access as traffic and usage

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.8.1: Website is Accessible During Peak Traffic
**Given** a high number of users simultaneously access the website  
**When** peak traffic occurs  
**Then**
- The website remains accessible without significant delays
- No server errors (e.g., 503 Service Unavailable) are encountered

### Scenario 1.8.2: Automatic Failover and Redundancy
**Given** a failure of a primary server or component  
**When** an outage or hardware failure occurs  
**Then**
- The website automatically redirects traffic to backup or redundant systems
- Users experience minimal or no service interruption

### Scenario 1.8.3: Monitoring and Alerting for Downtime
**Given** a monitoring system is in place  
**When** the website becomes unavailable or response times degrade  
**Then**
- The support/engineering team is alerted immediately
- Uptime and downtime incidents are logged for review

### Scenario 1.8.4: Status Page Availability
**Given** there is an ongoing outage or major incident  
**When** users attempt to access the website  
**Then**
- A status page or notification is presented with up-to-date information

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                            |
|-------------|------------------------------------------------------------------|
| 1.8.1       | Test_1_8_HighAvailability::test_1_8_1_AccessibleDuringPeakTraffic|
| 1.8.2       | Test_1_8_HighAvailability::test_1_8_2_AutomaticFailover          |
| 1.8.3       | Test_1_8_HighAvailability::test_1_8_3_MonitoringAndAlerting      |
| 1.8.4       | Test_1_8_HighAvailability::test_1_8_4_StatusPageAvailability     |