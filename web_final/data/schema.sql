-- Creative Portfolio & Booking System Database Schema

CREATE DATABASE IF NOT EXISTS portfolio_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE portfolio_booking;

-- Table 1: Portfolio Items (Gallery)
CREATE TABLE IF NOT EXISTS portfolio_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    featured BOOLEAN DEFAULT FALSE
);

-- Table 2: Bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    client_email VARCHAR(255) NOT NULL,
    client_phone VARCHAR(50),
    service_type VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME,
    message TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Portfolio items table is ready for your data
-- Use add_portfolio_item.php or insert data directly via SQL
-- 
-- Example:
-- INSERT INTO portfolio_items (title, category, description, image_url, featured) 
-- VALUES ('Dish Name', 'Category', 'Description', 'image_url', TRUE/FALSE);
