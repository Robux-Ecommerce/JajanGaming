<?php
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->exec('USE jajangaming');
    $result = $pdo->query('SELECT COUNT(*) FROM admin_wallets');
    echo 'admin_wallets table: ' . $result->fetchColumn() . " records\n";
    $result2 = $pdo->query('SELECT COUNT(*) FROM admin_tax_histories');
    echo 'admin_tax_histories table: ' . $result2->fetchColumn() . " records\n";
    echo "✅ Tables exist and ready!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
