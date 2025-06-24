# Test 3.6 – Delete Existing Product

## User Story
As an admin user  
I need to delete existing products  
So that obsolete products are not available to website visitors

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.6.1: Successful Product Deletion
**Given** an admin is logged into the admin area  
**When** the admin deletes an existing product  
**Then**
- The product is removed from the system or marked as deleted
- The product is no longer visible to website visitors
- The admin receives confirmation of the deletion

### Scenario 3.6.2: Cannot Delete Nonexistent Product
**Given** an admin attempts to delete a product that does not exist  
**When** the deletion is attempted  
**Then**
- The system informs the admin that the product does not exist
- No changes are made to products in the system

### Scenario 3.6.3: Audit Log of Product Deletion
**Given** an admin deletes an existing product  
**When** the deletion is completed  
**Then**
- An audit log records the admin’s identity, the product identifier, the action taken, and the timestamp

### Scenario 3.6.4: Deleted Products Not Accessible
**Given** a product has been deleted by an admin  
**When** a website visitor or API attempts to access the deleted product  
**Then**
- The product is not accessible or returns a "not found" response

### Scenario 3.6.5: Prevent Deletion of Linked Products (Optional)
**Given** a product is linked to active orders or other constraints  
**When** the admin attempts to delete the product  
**Then**
- The system prevents deletion and informs the admin of the reason

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                             |
|-------------|-------------------------------------------------------------------|
| 3.6.1       | Test_3_6_DeleteExistingProduct::test_3_6_1_SuccessfulProductDeletion    |
| 3.6.2       | Test_3_6_DeleteExistingProduct::test_3_6_2_CannotDeleteNonexistentProduct |
| 3.6.3       | Test_3_6_DeleteExistingProduct::test_3_6_3_AuditLogOfProductDeletion    |
| 3.6.4       | Test_3_6_DeleteExistingProduct::test_3_6_4_DeletedProductsNotAccessible |
| 3.6.5       | Test_3_6_DeleteExistingProduct::test_3_6_5_PreventDeletionOfLinkedProducts |