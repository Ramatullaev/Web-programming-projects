-- Quick add Kazakh dishes for testing
-- Execute this SQL in phpMyAdmin after creating the database

USE portfolio_booking;

-- Clear existing data (optional)
-- TRUNCATE TABLE portfolio_items;

-- Portfolio items table is ready for your data
-- Add your dishes using add_portfolio_item.php or insert directly via SQL

-- Example structure for adding a dish:
-- INSERT INTO portfolio_items (title, category, description, image_url, featured) 
-- VALUES ('Dish Name', 'Category', 'Description', 'image_url', TRUE/FALSE);

-- Check inserted items
SELECT * FROM portfolio_items;
