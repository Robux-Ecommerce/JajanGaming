-- SQL script to add seller_id column to products table
-- Run this in your MySQL database if migration cannot be run

ALTER TABLE `products` 
ADD COLUMN `seller_id` BIGINT UNSIGNED NULL AFTER `id`;

ALTER TABLE `products` 
ADD CONSTRAINT `products_seller_id_foreign` 
FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- Update existing products to set seller_id based on seller_name
-- This will match products with sellers by name
UPDATE `products` p
INNER JOIN `users` u ON p.seller_name = u.name AND u.role = 'seller'
SET p.seller_id = u.id
WHERE p.seller_id IS NULL;

