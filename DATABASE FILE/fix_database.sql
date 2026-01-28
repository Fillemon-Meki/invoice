-- Fix for Invoice Management System Database Issues
-- Run this SQL script to fix duplicate invoice numbers and add proper constraints

-- Step 1: First, let's see which invoices have duplicates (for information only)
-- SELECT invoice, COUNT(*) as count FROM invoices GROUP BY invoice HAVING count > 1;

-- Step 2: Update the invoices table to make invoice field UNIQUE
-- Note: You may need to manually fix duplicate invoice numbers first
-- For now, we'll add the constraint for future inserts

-- Add unique constraint to invoices table (if not exists)
ALTER TABLE `invoices` 
ADD UNIQUE KEY `unique_invoice` (`invoice`);

-- Step 3: Add index to improve performance
ALTER TABLE `invoice_items` 
ADD INDEX `idx_invoice` (`invoice`);

ALTER TABLE `customers` 
ADD INDEX `idx_invoice` (`invoice`);

-- Optional: Update invoice field type to INT for better performance
-- ALTER TABLE `invoices` MODIFY `invoice` INT(11) NOT NULL;
-- ALTER TABLE `customers` MODIFY `invoice` INT(11) NOT NULL;
-- ALTER TABLE `invoice_items` MODIFY `invoice` INT(11) NOT NULL;
