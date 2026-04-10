# CLSICT0062 AT2 - Feedback Corrections Summary

## Issue Reference
Issue #1: CLSICT0062 AT2 - Corrections from feedback

## Feedback Items Addressed

### 1. WCAG Version Update ✅
**Feedback:** "The current version of WCAG is v2.2"

**Changes Made:**
- Updated `tests/backend/6_UserInterface/Test_6_10_AccessibilityFeaturesTest.php`
- Changed accessibility test tags from `["wcag2a", "wcag2aa"]` to `["wcag22a", "wcag22aa"]`
- This ensures the application is tested against WCAG 2.2 Level AA standards

### 2. Database Creation ✅
**Feedback:** "You have not created the database as per the specifications given."

**Changes Made:**
- Created `database_schema.sql` - Complete SQL script to create the database
- Created `DATABASE.md` - Comprehensive documentation of database structure
- Documents all tables: permissions, user, manufacturer, products, features, orders, order_items, changelog

### 3. Features Table with One-to-One Relationship ✅
**Feedback:** "You need to create a features table in your database. The product-feature table is a one-to-one relationship."

**Implementation Verified:**
- Features table already exists and is properly implemented
- One-to-one relationship enforced by UNIQUE constraint on `features.product_ID`
- Each product can have at most one set of features
- Each feature record belongs to exactly one product
- Foreign key with CASCADE delete ensures data integrity

**Schema:**
```sql
CREATE TABLE features (
    featureID INT AUTO_INCREMENT PRIMARY KEY,
    product_ID INT NOT NULL UNIQUE,  -- UNIQUE ensures one-to-one
    weight, height, width, thickness, operating_system,
    screensize, resolution, cpu, ram, storage, battery,
    rear_camera, front_camera,
    FOREIGN KEY (product_ID) REFERENCES products(product_ID) ON DELETE CASCADE
);
```

### 4. Product Detail View Shows Features ✅
**Feedback:** "When viewing an individual product the information from both the product and features table should be displayed."

**Implementation Verified:**
- Already implemented in `controller/detailproduct.php`
- Uses `get_product_with_features()` function to fetch data from both tables
- View `view/product_detail.php` displays all product and feature information
- Features shown include: weight, height, width, thickness, OS, screen, resolution, CPU, RAM, storage, battery, cameras

### 5. Adding Products Also Adds Features ✅
**Feedback:** "When a user adds a new product they should also be adding the features with the data written to the appropriate table."

**Implementation Verified:**
- Already implemented in `controller/addnewproduct.php`
- Process:
  1. Insert product into products table
  2. Get product_ID using lastInsertId()
  3. Insert features into features table using the product_ID
- Form in `view/add_product.php` includes all feature fields

### 6. Fixed Warnings on Admin Product Page ✅
**Feedback:** "After adding or deleting a product the resulting page (admin_product.php) is showing two warnings"

**Changes Made:**
- Fixed undefined variable warnings in `view/admin_product.php`
  - Added safety checks for $manufacturers and $products variables
  - Default to empty arrays if not set
- Fixed undefined variable warnings in `index.php`
  - Added initialization of required variables if accessed directly
  - Added database connection verification
- These changes prevent PHP warnings when variables are not set

### 7. Improved Error Handling ✅
**Feedback:** "You need to consider your errors when adding data to the database. For example when trying to add a new customer if the formats are not correct (and there is no indication of what the format should be) there are no errors or warnings displayed and the user is returned to the screen not knowing what was wrong."

**Changes Made:**
- Added error and success message display to `view/register.php`
- Added error and success message display to `view/add_user.php`
- Error messages now properly displayed using Bootstrap alert components
- Format requirements shown in:
  - Placeholder text (e.g., "Min 8 chars, incl. upper, lower, number, special")
  - HTML5 pattern validation with title attributes
  - Server-side validation with detailed error messages
- Users now see clear feedback when validation fails

## Files Modified
1. `tests/backend/6_UserInterface/Test_6_10_AccessibilityFeaturesTest.php` - WCAG 2.2 update
2. `view/register.php` - Added error/success message display
3. `view/add_user.php` - Added error/success message display
4. `view/admin_product.php` - Fixed undefined variable warnings
5. `index.php` - Fixed undefined variable warnings, added connection check

## Files Created
1. `database_schema.sql` - Complete database creation script
2. `DATABASE.md` - Database structure documentation
3. `FEEDBACK_CORRECTIONS.md` - This summary document

## Testing
- ✅ Code review completed - no major issues
- ✅ CodeQL security scan - no vulnerabilities found
- ✅ All error messages properly escaped with htmlspecialchars()
- ✅ Database connection verified before use

## Verification
All feedback items have been addressed:
- [x] WCAG v2.2 compliance
- [x] Database schema documented and created
- [x] Features table with one-to-one relationship
- [x] Product detail view shows features
- [x] Adding products adds features
- [x] Fixed warnings in admin pages
- [x] Improved error handling and user feedback
