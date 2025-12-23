<?php

// Ini script untuk setup Admin Wallet tables secara manual
// Run di terminal: php database/setup_admin_wallet.php

try {
    // Koneksi ke database
    $host = 'localhost';
    $db = 'jajangaming';
    $user = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host", $user, $password);
    
    // Create database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    
    // Select database
    $pdo->exec("USE $db");
    
    echo "✓ Connected to database\n";
    
    // Create admin_wallets table
    $sql1 = "CREATE TABLE IF NOT EXISTS admin_wallets (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        total_balance DECIMAL(15, 2) DEFAULT 0,
        total_tax_collected DECIMAL(15, 2) DEFAULT 0,
        last_updated TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )";
    
    $pdo->exec($sql1);
    echo "✓ Created admin_wallets table\n";
    
    // Create admin_tax_histories table
    $sql2 = "CREATE TABLE IF NOT EXISTS admin_tax_histories (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        transaction_id BIGINT UNSIGNED NULL,
        order_id BIGINT UNSIGNED NULL,
        amount DECIMAL(15, 2),
        tax_rate DECIMAL(5, 2) DEFAULT 10.00,
        description VARCHAR(255) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        INDEX idx_created_at (created_at),
        INDEX idx_created_amount (created_at, amount),
        FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE SET NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
    )";
    
    $pdo->exec($sql2);
    echo "✓ Created admin_tax_histories table\n";
    
    // Insert initial admin wallet data
    $sql3 = "INSERT INTO admin_wallets (total_balance, total_tax_collected, last_updated, created_at, updated_at) 
             VALUES (0, 0, NOW(), NOW(), NOW()) 
             ON DUPLICATE KEY UPDATE updated_at = NOW()";
    
    $pdo->exec($sql3);
    echo "✓ Initialized admin wallet data\n";
    
    echo "\n✅ Admin Wallet setup completed successfully!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
