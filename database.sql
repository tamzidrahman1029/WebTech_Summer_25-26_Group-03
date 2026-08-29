-- ============================================================
-- Bike Shop - database.sql
-- Database: sell_bike  (kept as the existing name used in db.php)
-- Run this on MySQL (Homebrew, user: root, no XAMPP needed)
-- ============================================================

CREATE DATABASE IF NOT EXISTS sell_bike;
USE sell_bike;

-- ------------------------------------------------------------
-- bikes
-- This table was already assumed by the existing Seller code
-- (BikeShop/Model/db.php -> addBike(), BikeShop/View/SellingProducts.php)
-- but no CREATE TABLE existed anywhere in the repo, so it is
-- created here to match exactly what addBike() inserts and what
-- SellingProducts.php selects.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS bikes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bike_name VARCHAR(150) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT NOT NULL,
    bike_image VARCHAR(255) NOT NULL
);

-- Seed data taken from BikeShop/Model/bikes.json so the Customer
-- side has something to browse immediately (uses the images that
-- actually exist under BikeShop/Uploads/).
INSERT INTO bikes (bike_name, brand, model, price, quantity, description, bike_image) VALUES
('yamaha v3', 'yamaha', '2024', 220000.00, 2, 'single channel abs, fi engine', '../Uploads/yamaha-fzs-v3.webp'),
('yamaha v4', 'yamaha', '2025', 270000.00, 1, 'dual channel abs', '../Uploads/yamaha-fzs-v4.webp'),
('yamaha mt-15', 'yamaha', '2025', 320000.00, 1, 'naked sport bike, dual channel abs', '../Uploads/yamaha-mt-15.webp');

-- ------------------------------------------------------------
-- customers
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- cart_items
-- One row per (customer, bike). Belongs to a single customer.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    bike_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_customer_bike (customer_id, bike_id),
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (bike_id) REFERENCES bikes(id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- orders
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Placed',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- order_items
-- Stores a snapshot of bike name/price at order time so the
-- order history stays accurate even if a bike is later changed.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    bike_id INT NOT NULL,
    bike_name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (bike_id) REFERENCES bikes(id) ON DELETE RESTRICT
);
