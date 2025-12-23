-- Create admin_wallets table
CREATE TABLE IF NOT EXISTS admin_wallets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    total_balance DECIMAL(15, 2) DEFAULT 0,
    total_tax_collected DECIMAL(15, 2) DEFAULT 0,
    last_updated TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create admin_tax_histories table
CREATE TABLE IF NOT EXISTS admin_tax_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id BIGINT UNSIGNED NULL,
    order_id BIGINT UNSIGNED NULL,
    amount DECIMAL(15, 2),
    tax_rate DECIMAL(3, 2) DEFAULT 10,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_created_at (created_at),
    INDEX idx_created_amount (created_at, amount),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE SET NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
);

-- Insert initial admin wallet data
INSERT INTO admin_wallets (total_balance, total_tax_collected, last_updated, created_at, updated_at) 
VALUES (0, 0, NOW(), NOW(), NOW()) 
ON DUPLICATE KEY UPDATE updated_at = NOW();
