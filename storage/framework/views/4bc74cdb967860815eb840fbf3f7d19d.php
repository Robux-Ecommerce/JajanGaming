

<?php $__env->startSection('title', 'Dompet Seller - JajanGaming'); ?>

<?php $__env->startSection('content'); ?>
<main style="padding: 2rem 0; background: #0a1218; min-height: calc(100vh - 70px);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <h1 style="color: #64a0b4; font-size: 2rem; margin-bottom: 2rem;">
            <i class="fas fa-wallet"></i> Dompet Penjual
        </h1>

        <!-- Balance Card -->
        <div style="background: linear-gradient(135deg, rgba(201, 168, 86, 0.2) 0%, rgba(201, 168, 86, 0.05) 100%); border: 1px solid rgba(201, 168, 86, 0.3); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
            <p style="color: #999; margin: 0; font-size: 0.9rem;">Saldo Dompet</p>
            <h2 style="color: #c9a856; font-size: 2.5rem; margin: 0.5rem 0;">Rp <?php echo e(number_format($seller->wallet_balance, 0, ',', '.')); ?></h2>
        </div>

        <!-- Transactions -->
        <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 2rem;">
            <h3 style="color: #64a0b4; margin-top: 0; margin-bottom: 1.5rem;">Riwayat Transaksi</h3>
            <p style="color: #999; text-align: center;">Belum ada transaksi</p>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/seller/wallet.blade.php ENDPATH**/ ?>