# Database Documentation

## Database Structure

The Mobile Hour application uses a MySQL database with the following key tables:

### Core Tables

1. **permissions** - Defines user roles (Customer, Admin, Manager)
2. **user** - Stores user account information
3. **manufacturer** - Mobile phone manufacturers
4. **products** - Mobile phone products
5. **features** - Product specifications (one-to-one with products)
6. **orders** - Customer orders
7. **order_items** - Items within each order
8. **changelog** - Audit trail for data changes

## One-to-One Relationship: Products and Features

As specified in the requirements, the relationship between **products** and **features** tables is **one-to-one**:

- Each product can have **at most one** set of features
- Each feature record belongs to **exactly one** product
- This is enforced by the `UNIQUE` constraint on `features.product_ID`

### Schema Definition

```sql
CREATE TABLE features (
    featureID INT AUTO_INCREMENT PRIMARY KEY,
    product_ID INT NOT NULL UNIQUE,  -- UNIQUE ensures one-to-one relationship
    weight DECIMAL(10, 2),
    height DECIMAL(10, 2),
    width DECIMAL(10, 2),
    thickness DECIMAL(10, 2),
    operating_system VARCHAR(100),
    screensize DECIMAL(5, 2),
    resolution VARCHAR(50),
    cpu VARCHAR(100),
    ram INT,
    storage INT,
    battery INT,
    rear_camera VARCHAR(50),
    front_camera VARCHAR(50),
    FOREIGN KEY (product_ID) REFERENCES products(product_ID) ON DELETE CASCADE
);
```

### Implementation

When adding a new product:
1. Product details are inserted into the `products` table
2. The `product_ID` is retrieved using `lastInsertId()`
3. Features are inserted into the `features` table using the `product_ID`

See: `controller/addnewproduct.php` for the implementation.

### Displaying Features

When viewing a product, both product and feature information is displayed together:
- Controller: `controller/detailproduct.php`
- Function: `get_product_with_features()` in `model/functions.php`
- View: `view/product_detail.php`

## Database Setup

To create the database, run the SQL script:
```bash
mysql -u root -p < database_schema.sql
```

Or import it using phpMyAdmin or MySQL Workbench.

## WCAG Compliance

The application follows **WCAG 2.2** Level AA accessibility standards.
Accessibility tests are located in: `tests/backend/6_UserInterface/Test_6_10_AccessibilityFeaturesTest.php`
