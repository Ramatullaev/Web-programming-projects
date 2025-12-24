-- Clear all portfolio items from database
-- Execute this SQL in phpMyAdmin to remove all existing dishes

USE portfolio_booking;

-- Delete all portfolio items
DELETE FROM portfolio_items;

-- Reset auto increment
ALTER TABLE portfolio_items AUTO_INCREMENT = 1;

-- Verify table is empty
SELECT COUNT(*) as remaining_items FROM portfolio_items;

