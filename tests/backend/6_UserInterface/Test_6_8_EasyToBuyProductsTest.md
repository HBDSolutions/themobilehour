# Test 6.8 – Easy to Buy Products

## User Story
As an application user  
I want to buy products online with minimal steps and clear guidance  
So that I can complete my purchase quickly and without confusion

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.8.1: "Add to Cart" Button is Clearly Visible on Product Details
**Given** I am viewing a product details page  
**When** the page loads  
**Then** there is a clearly visible "Add to Cart" button

### Scenario 6.8.2: Cart is Easily Accessible from All Pages
**Given** I am browsing the application  
**When** I want to view my cart  
**Then** there is a cart icon or link visible on all pages

### Scenario 6.8.3: Checkout Process is Simple and Linear
**Given** I have added products to my cart  
**When** I proceed to checkout  
**Then** I am guided through a simple, step-by-step process to complete my purchase

### Scenario 6.8.4: Purchase Confirmation is Clear and Immediate
**Given** I have completed the checkout process  
**When** my payment is successful  
**Then** I receive a clear confirmation message and order summary

---

## Traceability

| Scenario ID | Maps to Test Method                                                |
|-------------|--------------------------------------------------------------------|
| 6.8.1       | Test_6_8_EasyToBuyProducts::test_6_8_1_AddToCartVisible            |
| 6.8.2       | Test_6_8_EasyToBuyProducts::test_6_8_2_CartAccessible              |
| 6.8.3       | Test_6_8_EasyToBuyProducts::test_6_8_3_CheckoutIsSimple            |
| 6.8.4       | Test_6_8_EasyToBuyProducts::test_6_8_4_PurchaseConfirmation        |