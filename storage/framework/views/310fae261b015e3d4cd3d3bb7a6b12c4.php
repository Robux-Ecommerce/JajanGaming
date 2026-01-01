

<?php $__env->startSection('title', 'Dompet Admin - JajanGaming'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; min-height: calc(100vh - 80px); background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);">
    <?php echo $__env->make('partials.sidebar', ['sidebarTitle' => 'Admin Wallet'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-2" style="color: #ffffff; font-weight: 700;">
                                <i class="fas fa-wallet me-2" style="color: #64a0b4;"></i>Dompet Admin
                            </h1>
                            <p class="mb-0" style="color: #a0b5c5; font-size: 1rem;">Kelola pendapatan dari pajak transaksi 10%</p>
                        </div>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stats-card total">
                        <div class="stats-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Total Saldo</h6>
                            <h3>Rp <?php echo e(number_format($adminWallet->total_balance, 0, ',', '.')); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stats-card success">
                        <div class="stats-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Total Pajak Terkumpul</h6>
                            <h3>Rp <?php echo e(number_format($adminWallet->total_tax_collected, 0, ',', '.')); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stats-card warning">
                        <div class="stats-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Pajak Hari Ini</h6>
                            <h3>Rp <?php echo e(number_format($todayTax, 0, ',', '.')); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stats-card info">
                        <div class="stats-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Pajak Bulan Ini</h6>
                            <h3>Rp <?php echo e(number_format($thisMonthTax, 0, ',', '.')); ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- Monthly Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 bg-primary text-white">
                            <h5 class="m-0 font-weight-bold">
                                <i class="fas fa-chart-line me-2"></i>Grafik Pendapatan Pajak (12 Bulan Terakhir)
                            </h5>
                        </div>
                        <div class="card-body" style="position: relative; height: 300px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Daily Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 bg-primary text-white">
                            <h5 class="m-0 font-weight-bold">
                                <i class="fas fa-chart-bar me-2"></i>Pajak Bulan Ini
                            </h5>
                        </div>
                        <div class="card-body" style="position: relative; height: 300px;">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History & Export -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-history me-2"></i>Riwayat Pajak Terbaru
                    </h5>
                    <div>
                        <a href="<?php echo e(route('admin.wallet.history')); ?>" class="btn btn-sm btn-light">
                            <i class="fas fa-list me-1"></i>Lihat Semua
                        </a>
                        <a href="<?php echo e(route('admin.wallet.export')); ?>" class="btn btn-sm btn-light">
                            <i class="fas fa-download me-1"></i>Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($recentTaxes->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%">Tanggal</th>
                                        <th style="width: 20%">Order ID</th>
                                        <th style="width: 20%">Jumlah Pajak</th>
                                        <th style="width: 20%">Tarif</th>
                                        <th style="width: 20%">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentTaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <small><?php echo e($tax->created_at->format('d M Y, H:i')); ?></small>
                                            </td>
                                            <td>
                                                <?php if($tax->order_id): ?>
                                                    <span class="badge bg-primary"><?php echo e($tax->order_id); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong class="text-success">Rp <?php echo e(number_format($tax->amount, 0, ',', '.')); ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($tax->tax_rate); ?>%</span>
                                            </td>
                                            <td>
                                                <small><?php echo e($tax->description ?? '-'); ?></small>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox text-muted fa-2x mb-2 d-block"></i>
                                                <small class="text-muted">Belum ada riwayat pajak</small>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox text-muted fa-4x mb-3"></i>
                            <h5 class="text-muted">Tidak ada data riwayat</h5>
                            <p class="text-muted">Riwayat pajak akan muncul setelah ada transaksi pembelian</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info Box -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info border-0" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Dompet admin mengumpulkan pajak sebesar 10% dari setiap transaksi pembelian. Pajak ini akan terakumulasi dan dapat digunakan untuk operasional platform.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Background */
    body, .page-wrapper {
        background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%) !important;
        color: #ffffff;
    }

    /* Stats Cards */
    .stats-card {
        padding: 1.5rem;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
        pointer-events: none;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .stats-card.total {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        border: 2px solid rgba(100, 160, 180, 0.3);
    }

    .stats-card.success {
        background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%);
        border: 2px solid rgba(110, 190, 150, 0.3);
    }

    .stats-card.warning {
        background: linear-gradient(135deg, #e8b056 0%, #d68940 100%);
        border: 2px solid rgba(232, 176, 86, 0.3);
    }

    .stats-card.info {
        background: linear-gradient(135deg, #5eb8c4 0%, #3a9aac 100%);
        border: 2px solid rgba(94, 184, 196, 0.3);
    }

    .stats-icon {
        font-size: 2.5rem;
        opacity: 1;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .stats-content {
        position: relative;
        z-index: 1;
    }

    .stats-content h6 {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.7rem;
        opacity: 1;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .stats-content h3 {
        font-size: 1.9rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
        transition: all 0.3s ease;
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .card-header {
        border-bottom: 2px solid rgba(100, 160, 180, 0.3);
        border-radius: 14px 14px 0 0 !important;
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        color: white;
        font-weight: 700;
        padding: 1.25rem !important;
    }

    .card-body {
        background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
        color: #ffffff;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border: none;
        transition: all 0.3s ease;
        font-weight: 600;
        color: white;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #4a8a94 0%, #3a7a90 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(100, 160, 180, 0.4);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #4a8a94 0%, #3a7a90 100%);
        box-shadow: 0 6px 15px rgba(100, 160, 180, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%);
        border: none;
        font-weight: 600;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #5aae86 0%, #398a60 100%);
    }

    .table {
        color: #e0e0e0;
        border-color: rgba(100, 160, 180, 0.2);
    }

    .table-hover tbody tr {
        background-color: transparent;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(100, 160, 180, 0.1) !important;
        border-color: rgba(100, 160, 180, 0.3);
    }

    .table thead {
        background: rgba(100, 160, 180, 0.1);
        border-color: rgba(100, 160, 180, 0.3);
    }

    .table-light {
        background: rgba(100, 160, 180, 0.15) !important;
    }

    .badge {
        font-weight: 600;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(100, 160, 180, 0.3) !important;
        color: #ffffff !important;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .form-label {
        color: #a0b5c5;
        font-weight: 600;
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(94, 184, 196, 0.1) 100%);
        border: 2px solid rgba(100, 160, 180, 0.3);
        color: #a0c5d5;
    }

    .pagination {
        gap: 0.5rem;
    }

    .page-link {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.3);
        color: #64a0b4;
        font-weight: 600;
    }

    .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
        border-color: rgba(100, 160, 180, 0.5);
        color: #ffffff;
    }

    .page-link.active {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border-color: #64a0b4;
    }

    @media (max-width: 768px) {
        .stats-content h3 {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
        }

        .card-header .btn {
            width: 100%;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($monthlyData['labels'], 15, 512) ?>,
            datasets: [{
                label: 'Pendapatan Pajak (Rp)',
                data: <?php echo json_encode($monthlyData['data'], 15, 512) ?>,
                borderColor: '#64a0b4',
                backgroundColor: 'rgba(100, 160, 180, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#64a0b4',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 12, weight: 'bold' },
                        color: '#666',
                        padding: 15,
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Daily Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($dailyData['labels'], 15, 512) ?>,
            datasets: [{
                label: 'Pajak (Rp)',
                data: <?php echo json_encode($dailyData['data'], 15, 512) ?>,
                backgroundColor: 'rgba(100, 160, 180, 0.7)',
                borderColor: '#64a0b4',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 11, weight: 'bold' },
                        color: '#666',
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/admin/wallet/index.blade.php ENDPATH**/ ?>