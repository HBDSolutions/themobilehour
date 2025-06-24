# Test 3.4 – Add New Product

## User Story
As an admin user  
I need to add new products to the website  
So that website visitors can browse and buy the latest offerings

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.4.1: Successful Product Addition
**Given** an admin is logged into the admin area  
**When** the admin completes the "Add Product" form with valid details and submits  
**Then**
- The product is saved in the system
- The product appears on the website for visitors to view and purchase
- The admin receives confirmation of the addition

### Scenario 3.4.2: Product Validation Errors
**Given** an admin is adding a new product  
**When** the admin submits the form with missing or invalid data (e.g., blank name, invalid price)  
**Then**
- The system prevents product creation
- The admin is shown clear validation error messages

### Scenario 3.4.3: Unique Product Identification
**Given** an admin adds a product with a name or SKU that already exists  
**When** the form is submitted  
**Then**
- The system prevents duplicate entries and informs the admin

### Scenario 3.4.4: Audit Log of Product Addition
**Given** an admin adds a new product  
**When** the addition is completed  
**Then**
- An audit log records the admin’s identity, product details, and timestamp

### Scenario 3.4.5: Product Not Displayed if "Inactive"
**Given** an admin adds a new product and marks it as "inactive" or "draft"  
**When** the product is submitted  
**Then**
- The product is not visible to website visitors, but is stored in the system

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                            |
|-------------|------------------------------------------------------------------|
| 3.4.1       | Test_3_4_AddNewProduct::test_3_4_1_SuccessfulProductAddition     |
| 3.4.2       | Test_3_4_AddNewProduct::test_3_4_2_ProductValidationErrors       |
| 3.4.3       | Test_3_4_AddNewProduct::test_3_4_3_UniqueProductIdentification   |
| 3.4.4       | Test_3_4_AddNewProduct::test_3_4_4_AuditLogOfProductAddition     |
| 3.4.5       | Test_3_4_AddNewProduct::test_3_4_5_ProductNotDisplayedIfInactive |