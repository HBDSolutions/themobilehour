-- The Mobile Hour Database Schema
-- This schema represents the database structure as implemented in the application

-- Create database
CREATE DATABASE IF NOT EXISTS mobile_hour CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mobile_hour;

-- Permissions table
CREATE TABLE IF NOT EXISTS permissions (
    permissionsID INT AUTO_INCREMENT PRIMARY KEY,
    permissions_role VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- User table
CREATE TABLE IF NOT EXISTS user (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    shipping_address TEXT,
    permissionsID INT NOT NULL DEFAULT 1,
    isActive TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (permissionsID) REFERENCES permissions(permissionsID)
) ENGINE=InnoDB;

-- Manufacturer table
CREATE TABLE IF NOT EXISTS manufacturer (
    manufacturer_ID INT AUTO_INCREMENT PRIMARY KEY,
    manufacturer_Name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    product_ID INT AUTO_INCREMENT PRIMARY KEY,
    product_Name VARCHAR(255) NOT NULL,
    manufacturer_ID INT NOT NULL,
    product_Description TEXT,
    stock_on_hand INT NOT NULL DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    special TINYINT(1) DEFAULT 0,
    FOREIGN KEY (manufacturer_ID) REFERENCES manufacturer(manufacturer_ID)
) ENGINE=InnoDB;

-- Features table (one-to-one relationship with products)
CREATE TABLE IF NOT EXISTS features (
    featureID INT AUTO_INCREMENT PRIMARY KEY,
    product_ID INT NOT NULL UNIQUE,
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
) ENGINE=InnoDB;

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    status VARCHAR(50) DEFAULT 'pending',
    FOREIGN KEY (userID) REFERENCES user(userID)
) ENGINE=InnoDB;

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    order_item_ID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT NOT NULL,
    product_ID INT NOT NULL,
    quantity INT NOT NULL,
    price_at_time DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (orderID) REFERENCES orders(orderID) ON DELETE CASCADE,
    FOREIGN KEY (product_ID) REFERENCES products(product_ID)
) ENGINE=InnoDB;

-- Changelog table
CREATE TABLE IF NOT EXISTS changelog (
    change_id INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    old_values TEXT,
    new_values TEXT,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES user(userID)
) ENGINE=InnoDB;

-- Insert default permissions
INSERT INTO permissions (permissionsID, permissions_role) VALUES
(1, 'Customer'),
(2, 'Admin'),
(3, 'Manager')
ON DUPLICATE KEY UPDATE permissions_role=VALUES(permissions_role);
