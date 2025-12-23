<?php

// Database setup for Reports feature
$host = 'localhost';
$db = 'jajangaming';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create reports table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS reports (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            seller_id BIGINT UNSIGNED NOT NULL,
            product_id BIGINT UNSIGNED NOT NULL,
            reason VARCHAR(100) NOT NULL COMMENT 'poor_quality, fake_product, unsafe, inappropriate, other',
            description LONGTEXT NOT NULL,
            seller_response LONGTEXT NULL,
            admin_notes LONGTEXT NULL,
            status VARCHAR(50) DEFAULT 'pending' COMMENT 'pending, responded, resolved, dismissed',
            action_taken VARCHAR(100) NULL COMMENT 'none, warning, suspended, blacklisted',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            INDEX idx_seller_id (seller_id),
            INDEX idx_user_id (user_id),
            INDEX idx_status (status),
            INDEX idx_created_at (created_at),
            INDEX idx_seller_status (seller_id, status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    echo "✓ Reports table created successfully!\n";

    // Add is_blacklisted column to users table if not exists
    $columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('is_blacklisted', $columns)) {
        $pdo->exec("
            ALTER TABLE users 
            ADD COLUMN is_blacklisted BOOLEAN DEFAULT FALSE AFTER role
        ");
        echo "✓ is_blacklisted column added to users table!\n";
    } else {
        echo "✓ is_blacklisted column already exists!\n";
    }

    // Add suspended_reason column if not exists
    if (!in_array('suspended_reason', $columns)) {
        $pdo->exec("
            ALTER TABLE users 
            ADD COLUMN suspended_reason LONGTEXT NULL AFTER is_blacklisted,
            ADD COLUMN suspended_at TIMESTAMP NULL AFTER suspended_reason
        ");
        echo "✓ suspension columns added to users table!\n";
    } else {
        echo "✓ suspension columns already exist!\n";
    }

    echo "\nAll database tables set up successfully!\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
