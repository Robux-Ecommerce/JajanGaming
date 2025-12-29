

<?php $__env->startSection('title', 'Tambah Produk - Seller'); ?>

<?php $__env->startSection('content'); ?>
<main style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
        <h1 style="color: #64a0b4; font-size: 2rem; margin-bottom: 2rem;">
            <i class="fas fa-plus-circle"></i> Tambah Produk Baru
        </h1>

        <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 2rem;">
            <?php if($errors->any()): ?>
                <div style="background: rgba(244, 67, 54, 0.15); border-left: 4px solid #f44336; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('seller.products.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Nama Produk *</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Deskripsi *</label>
                    <textarea name="description" rows="5" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem; font-family: inherit;"><?php echo e(old('description')); ?></textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Nama Game *</label>
                    <input type="text" name="game_name" value="<?php echo e(old('game_name')); ?>" required
                        placeholder="Contoh: Mobile Legends, Free Fire, PUBG Mobile"
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Tipe Item *</label>
                        <select name="game_type" required
                            style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                            <option value="">Pilih Tipe</option>
                            <option value="diamond" <?php echo e(old('game_type') == 'diamond' ? 'selected' : ''); ?>>Diamond</option>
                            <option value="coins" <?php echo e(old('game_type') == 'coins' ? 'selected' : ''); ?>>Coins</option>
                            <option value="gems" <?php echo e(old('game_type') == 'gems' ? 'selected' : ''); ?>>Gems</option>
                            <option value="robux" <?php echo e(old('game_type') == 'robux' ? 'selected' : ''); ?>>Robux</option>
                            <option value="voucher" <?php echo e(old('game_type') == 'voucher' ? 'selected' : ''); ?>>Voucher</option>
                            <option value="other" <?php echo e(old('game_type') == 'other' ? 'selected' : ''); ?>>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Harga (Rp) *</label>
                        <input type="number" name="price" value="<?php echo e(old('price')); ?>" min="0" step="0.01" required
                            style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Stok *</label>
                    <input type="number" name="stock" value="<?php echo e(old('stock', 0)); ?>" min="0" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Gambar Produk</label>
                    <input type="file" name="image" accept="image/*"
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                    <small style="color: #999; display: block; margin-top: 0.5rem;">JPG, PNG, GIF (maks 2MB)</small>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                        <i class="fas fa-save me-2"></i>Simpan Produk
                    </button>
                    <a href="<?php echo e(route('seller.products.index')); ?>" style="background: rgba(100, 160, 180, 0.1); color: #64a0b4; padding: 0.75rem 2rem; border: 1px solid rgba(100, 160, 180, 0.2); border-radius: 8px; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/seller/products/create.blade.php ENDPATH**/ ?>