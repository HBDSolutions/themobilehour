# Test 6.4 – Logical Flow: Home > Product Search > Product Details > Add to Cart > Checkout

## User Story
As an application user  
I want a logical, intuitive flow from browsing to purchasing products  
So that I can easily find, select, and buy products online

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.4.1: User Can Navigate from Home to Product Search
**Given** I am on the home page  
**When** I use the product search or filter options  
**Then** I am shown a list of products matching my search or filters

### Scenario 6.4.2: User Can View Selected Product Details
**Given** I am viewing the search results  
**When** I select a product  
**Then** I am taken to a product details page with relevant information

### Scenario 6.4.3: User Can Add Product to Cart from Details Page
**Given** I am on a product details page  
**When** I click "Add to Cart"  
**Then** the selected product is added to my shopping cart

### Scenario 6.4.4: User Can Proceed to Checkout from Cart
**Given** I have added products to my cart  
**When** I view the cart and click "Checkout"  
**Then** I am taken to the checkout page to enter payment and shipping details

### Scenario 6.4.5: User Can Complete Purchase from Checkout
**Given** I am on the checkout page  
**When** I provide valid payment and shipping information and confirm  
**Then** my order is completed and I receive an order confirmation

---

## Traceability

| Scenario ID | Maps to Test Method                                                  |
|-------------|----------------------------------------------------------------------|
| 6.4.1       | Test_6_4_LogicalFlow::test_6_4_1_NavigateHomeToProductSearch         |
| 6.4.2       | Test_6_4_LogicalFlow::test_6_4_2_ViewSelectedProductDetails          |
| 6.4.3       | Test_6_4_LogicalFlow::test_6_4_3_AddProductToCart                    |
| 6.4.4       | Test_6_4_LogicalFlow::test_6_4_4_ProceedToCheckout                   |
| 6.4.5       | Test_6_4_LogicalFlow::test_6_4_5_CompletePurchase                    |