

<?php $__env->startSection('title', 'Laporan Pesanan - JajanGaming'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .orders-page {
        background: linear-gradient(180deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(30, 45, 60, 0.95) 0%, rgba(20, 35, 50, 0.95) 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        backdrop-filter: blur(20px);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #64a0b4;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Stats Summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-box {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.8), rgba(37, 53, 69, 0.8));
        border-radius: 12px;
        padding: 1.25rem;
        border-left: 3px solid #64a0b4;
        text-align: center;
    }

    .stat-box.pending { border-left-color: #c9a856; }
    .stat-box.processing { border-left-color: #64a0b4; }
    .stat-box.completed { border-left-color: #5cb890; }
    .stat-box.cancelled { border-left-color: #c47070; }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Filter & Search Bar */
    .filters-bar {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.7), rgba(37, 53, 69, 0.7));
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid rgba(100, 160, 180, 0.1);
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .search-input, .filter-select, .date-range {
        padding: 0.75rem 1rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 8px;
        color: #ffffff;
        font-size: 0.9rem;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .search-input:focus, .filter-select:focus, .date-range:focus {
        outline: none;
        border-color: #64a0b4;
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.1);
    }

    .search-input {
        flex: 1;
        min-width: 250px;
    }

    .filter-select, .date-range {
        min-width: 140px;
        cursor: pointer;
    }

    .export-btn {
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
    }

    /* Table Container */
    .table-container {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.7), rgba(37, 53, 69, 0.7));
        border-radius: 12px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .orders-table thead {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
        border-bottom: 2px solid rgba(100, 160, 180, 0.2);
    }

    .orders-table th {
        padding: 1rem;
        text-align: left;
        color: #ffffff;
        font-weight: 700;
        white-space: nowrap;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: rgba(100, 160, 180, 0.05);
    }

    .orders-table td {
        padding: 1rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .order-number {
        color: #64a0b4;
        font-weight: 600;
    }

    .customer-name {
        font-weight: 500;
    }

    .customer-email {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .amount {
        color: #4ade80;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.85rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .status-badge.pending {
        background: rgba(201, 168, 86, 0.2);
        color: #c9a856;
        border: 1px solid rgba(201, 168, 86, 0.3);
    }

    .status-badge.processing {
        background: rgba(100, 160, 180, 0.2);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .status-badge.completed {
        background: rgba(92, 184, 144, 0.2);
        color: #5cb890;
        border: 1px solid rgba(92, 184, 144, 0.3);
    }

    .status-badge.cancelled {
        background: rgba(196, 112, 112, 0.2);
        color: #c47070;
        border: 1px solid rgba(196, 112, 112, 0.3);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem 0.75rem;
        background: rgba(100, 160, 180, 0.1);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .btn-action:hover {
        background: rgba(100, 160, 180, 0.25);
        border-color: rgba(100, 160, 180, 0.4);
    }

    .pagination-container {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.7), rgba(37, 53, 69, 0.7));
        border-top: 1px solid rgba(100, 160, 180, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .page-link {
        padding: 0.4rem 0.75rem;
        background: rgba(100, 160, 180, 0.1);
        color: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .page-link.active {
        background: #64a0b4;
        color: white;
        border-color: #64a0b4;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        margin: 0;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .orders-page { padding: 1rem; }
        .filters-bar { flex-direction: column; }
        .search-input, .filter-select, .date-range { width: 100%; }
        .table-responsive { overflow-x: auto; }
        .orders-table th, .orders-table td { padding: 0.75rem; font-size: 0.8rem; }
    }
</style>

<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    <?php echo $__env->make('partials.sidebar', ['sidebarTitle' => 'Pesanan'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="orders-page">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <i class="fas fa-list"></i>
                    Laporan Pesanan
                </div>
                <div class="header-actions">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="export-btn">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="stats-summary">
                <div class="stat-box">
                    <div class="stat-number"><?php echo e($stats['total_orders'] ?? 0); ?></div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                <div class="stat-box pending">
                    <div class="stat-number"><?php echo e($stats['pending_orders'] ?? 0); ?></div>
                    <div class="stat-label">Tertunda</div>
                </div>
                <div class="stat-box processing">
                    <div class="stat-number"><?php echo e($stats['processing_orders'] ?? 0); ?></div>
                    <div class="stat-label">Diproses</div>
                </div>
                <div class="stat-box completed">
                    <div class="stat-number"><?php echo e($stats['completed_orders'] ?? 0); ?></div>
                    <div class="stat-label">Selesai</div>
                </div>
                <div class="stat-box cancelled">
                    <div class="stat-number"><?php echo e($stats['cancelled_orders'] ?? 0); ?></div>
                    <div class="stat-label">Dibatalkan</div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="filters-bar">
                <input type="text" class="search-input" id="searchInput" placeholder="Cari nomor pesanan, nama, email...">
                <select class="filter-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending">Tertunda</option>
                    <option value="processing">Diproses</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                <input type="date" class="date-range" id="dateFilter">
                <button class="export-btn" onclick="exportToCSV()">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>

            <!-- Orders Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="orders-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 15%;">Nomor Pesanan</th>
                                <th style="width: 20%;">Pelanggan</th>
                                <th style="width: 12%;">Jumlah</th>
                                <th style="width: 10%;">Item</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="table-row" data-status="<?php echo e($order->status); ?>">
                                <td class="row-number"><?php echo e($index + 1); ?></td>
                                <td class="order-number">
                                    <span class="badge-order">#<?php echo e($order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></span>
                                </td>
                                <td class="customer-column">
                                    <div class="customer-cell">
                                        <div class="customer-info-inline">
                                            <strong><?php echo e($order->user->name); ?></strong><br>
                                            <small><?php echo e($order->user->email); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="amount-column">
                                    <span class="amount-badge">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                                </td>
                                <td class="items-column">
                                    <span class="items-badge"><?php echo e($order->orderItems ? $order->orderItems->count() : 0); ?></span>
                                </td>
                                <td class="status-column">
                                    <span class="status-badge <?php echo e($order->status); ?>">
                                        <?php switch($order->status):
                                            case ('pending'): ?> Tertunda <?php break; ?>
                                            <?php case ('processing'): ?> Diproses <?php break; ?>
                                            <?php case ('completed'): ?> Selesai <?php break; ?>
                                            <?php case ('cancelled'): ?> Dibatalkan <?php break; ?>
                                            <?php default: ?> <?php echo e(ucfirst($order->status)); ?>

                                        <?php endswitch; ?>
                                    </span>
                                </td>
                                <td class="date-column"><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
                                <td class="action-column">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn-table-action btn-view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn-table-action btn-status" onclick="changeStatus(<?php echo e($order->id); ?>, '<?php echo e($order->status); ?>')" title="Ubah Status">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="empty-row">
                                <td colspan="8" class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum Ada Pesanan</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Menampilkan <?php echo e($orders->count()); ?> dari total pesanan
                </div>
                <?php if($orders->hasPages()): ?>
                <nav>
                    <?php echo e($orders->links('pagination::bootstrap-5')); ?>

                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const tableRows = document.querySelectorAll('.table-row');

    function filterTable() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const statusValue = statusFilter?.value || '';
        const dateValue = dateFilter?.value || '';

        tableRows.forEach(row => {
            let show = true;

            // Search filter
            if (searchTerm) {
                const orderNumber = row.querySelector('.order-number')?.textContent.toLowerCase();
                const customerInfo = row.querySelector('.customer-column')?.textContent.toLowerCase();
                show = show && (orderNumber?.includes(searchTerm) || customerInfo?.includes(searchTerm));
            }

            // Status filter
            if (statusValue) {
                show = show && row.dataset.status === statusValue;
            }

            // Date filter
            if (dateValue) {
                const rowDate = row.querySelector('.date-column')?.textContent.split(' ')[0];
                const filterDate = new Date(dateValue).toLocaleDateString('id-ID');
                show = show && rowDate === filterDate;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    searchInput?.addEventListener('keyup', filterTable);
    statusFilter?.addEventListener('change', filterTable);
    dateFilter?.addEventListener('change', filterTable);

    // Export to CSV
    function exportToCSV() {
        const table = document.getElementById('ordersTable');
        const rows = Array.from(table.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        
        let csv = 'Nomor Pesanan,Pelanggan,Email,Jumlah,Item,Status,Tanggal\n';
        
        rows.forEach(row => {
            if (!row.classList.contains('empty-row')) {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    cells[1]?.textContent.trim(),
                    cells[2]?.querySelector('strong')?.textContent || '',
                    cells[2]?.querySelector('small')?.textContent || '',
                    cells[3]?.textContent.replace('Rp ', '').trim(),
                    cells[4]?.textContent.trim(),
                    cells[5]?.textContent.trim(),
                    cells[6]?.textContent.trim()
                ];
                csv += rowData.map(cell => `"${cell}"`).join(',') + '\n';
            }
        });

        const link = document.createElement('a');
        link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        link.download = `pesanan_${new Date().getTime()}.csv`;
        link.click();
    }

    // Change status
    function changeStatus(orderId, currentStatus) {
        const statuses = ['pending', 'processing', 'completed', 'cancelled'];
        const statusLabels = {
            'pending': 'Tertunda',
            'processing': 'Diproses',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        const currentIndex = statuses.indexOf(currentStatus);
        const nextStatus = statuses[(currentIndex + 1) % statuses.length];
        
        if (confirm(`Ubah status menjadi "${statusLabels[nextStatus]}"?`)) {
            // AJAX call to update status
            fetch(`/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({ status: nextStatus })
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                }
            });
        }
    }
</script>

<style>
    /* Table Styling */
    .table-container {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.6), rgba(37, 53, 69, 0.6));
        border-radius: 12px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        color: #ffffff;
    }

    .orders-table thead {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.15), rgba(100, 160, 180, 0.05));
        border-bottom: 2px solid rgba(100, 160, 180, 0.2);
    }

    .orders-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        color: #64a0b4;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        transition: all 0.3s ease;
    }

    .orders-table tbody tr:hover {
        background: rgba(100, 160, 180, 0.08);
    }

    .orders-table td {
        padding: 1rem;
        font-size: 0.9rem;
    }

    .row-number {
        width: 5%;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
    }

    .badge-order {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .customer-cell {
        padding: 0.5rem 0;
    }

    .customer-info-inline strong {
        display: block;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }

    .customer-info-inline small {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .amount-badge {
        background: rgba(92, 184, 144, 0.15);
        color: #5cb890;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .items-badge {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        text-align: center;
        display: inline-block;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: none;
        letter-spacing: 0px;
        display: inline-block;
    }

    .status-badge.pending {
        background: rgba(201, 168, 86, 0.15);
        color: #c9a856;
        border: 1px solid rgba(201, 168, 86, 0.3);
    }

    .status-badge.processing {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .status-badge.completed {
        background: rgba(92, 184, 144, 0.15);
        color: #5cb890;
        border: 1px solid rgba(92, 184, 144, 0.3);
    }

    .status-badge.cancelled {
        background: rgba(196, 112, 112, 0.15);
        color: #c47070;
        border: 1px solid rgba(196, 112, 112, 0.3);
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        margin-right: 0.5rem;
    }

    .btn-view {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .btn-view:hover {
        background: rgba(100, 160, 180, 0.25);
        box-shadow: 0 4px 12px rgba(100, 160, 180, 0.2);
    }

    .btn-status {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .btn-status:hover {
        background: rgba(100, 160, 180, 0.25);
        box-shadow: 0 4px 12px rgba(100, 160, 180, 0.2);
    }

    .empty-row .empty-state {
        text-align: center;
        padding: 2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
        color: rgba(100, 160, 180, 0.3);
    }

    .empty-state p {
        margin: 0;
        font-size: 1rem;
    }

    /* Pagination Container */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: rgba(30, 45, 60, 0.4);
        border-radius: 12px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
    }

    .pagination-container nav {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }

    .pagination {
        margin: 0;
        gap: 0.5rem;
    }

    .page-item {
        display: inline-flex;
    }

    .page-link {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #64a0b4;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .page-link.active {
        background: #64a0b4;
        color: white;
        border-color: #64a0b4;
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .orders-page {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 1.2rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .filters-bar {
            flex-direction: column;
        }

        .search-input,
        .filter-select,
        .date-range {
            width: 100%;
        }

        .orders-table th,
        .orders-table td {
            padding: 0.75rem;
            font-size: 0.75rem;
        }

        .stats-summary {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .orders-table {
            min-width: 900px;
        }

        .pagination-container {
            flex-direction: column;
            text-align: center;
        }

        .pagination-container nav {
            justify-content: center;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .stats-summary {
            grid-template-columns: 1fr;
        }

        .stat-box {
            padding: 1rem;
        }

        .orders-table th,
        .orders-table td {
            padding: 0.5rem;
            font-size: 0.7rem;
        }

        .btn-table-action {
            width: 28px;
            height: 28px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>