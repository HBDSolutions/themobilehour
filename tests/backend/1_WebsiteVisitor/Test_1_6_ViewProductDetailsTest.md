# Test 1.6 – View Product Details

## User Story
As a website visitor  
I need to view detailed information and images about a specific product  
So that I can make an informed decision prior to buying

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.6.1: View Product Details Page
**Given** a website visitor clicks on a product from the product list  
**When** the product details page loads  
**Then**
- The page displays the product’s name, description, price, and availability
- The page shows a gallery or carousel of all available product images
- The page displays key attributes (e.g., brand, dimensions, specifications)

### Scenario 1.6.2: Image Zoom and Gallery Features
**Given** the product details page displays images  
**When** the visitor interacts with an image (e.g., clicks or hovers)
**Then**
- The image can be viewed in a larger format (e.g., lightbox or zoom)
- The visitor can browse through all available product images

### Scenario 1.6.3: Handling Missing Product Details
**Given** a specific product is missing some details or images  
**When** the details page loads  
**Then**
- The page gracefully indicates missing information (e.g., “Image not available”)
- The layout and core information remain usable

### Scenario 1.6.4: Product Not Found
**Given** a website visitor tries to view a product that does not exist  
**When** the details page loads  
**Then**
- An appropriate “Product not found” message is displayed

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                            |
|-------------|------------------------------------------------------------------|
| 1.6.1       | Test_1_6_ViewProductDetails::test_1_6_1_ViewProductDetailsPage   |
| 1.6.2       | Test_1_6_ViewProductDetails::test_1_6_2_ImageZoomAndGallery      |
| 1.6.3       | Test_1_6_ViewProductDetails::test_1_6_3_HandlingMissingDetails   |
| 1.6.4       | Test_1_6_ViewProductDetails::test_1_6_4_ProductNotFound          |