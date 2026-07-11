<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Overview<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$total_revenue = $total_revenue ?? 0;
$total_invoices = $total_invoices ?? 0;
$total_customers = $total_customers ?? 0;
$total_products = $total_products ?? 0;
$recent_invoices = $recent_invoices ?? [];
?>

<!-- KPI Widgets -->
<div class="widgets-grid">
    <div class="widget">
        <div class="widget-icon" style="background-color: rgba(16, 185, 129, 0.08); color: var(--success);">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div class="widget-data">
            <span class="widget-label">Total Pendapatan</span>
            <span class="widget-value">Rp <?= number_format($total_revenue, 0, ',', '.') ?></span>
        </div>
    </div>
    
    <div class="widget">
        <div class="widget-icon">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
        <div class="widget-data">
            <span class="widget-label">Total Invoices</span>
            <span class="widget-value"><?= $total_invoices ?></span>
        </div>
    </div>
    
    <div class="widget">
        <div class="widget-icon" style="background-color: rgba(2, 132, 199, 0.08); color: var(--info);">
            <i class="fa-solid fa-user-tag"></i>
        </div>
        <div class="widget-data">
            <span class="widget-label">Pelanggan</span>
            <span class="widget-value"><?= $total_customers ?></span>
        </div>
    </div>
    
    <div class="widget">
        <div class="widget-icon" style="background-color: rgba(245, 158, 11, 0.08); color: var(--warning);">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <div class="widget-data">
            <span class="widget-label">Produk / Barang</span>
            <span class="widget-value"><?= $total_products ?></span>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Recent Invoices Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transaksi Invoice Terbaru</h3>
            <a href="<?= base_url('invoices') ?>" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Faktur</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_invoices)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-muted);">Belum ada data transaksi.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_invoices as $invoice): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= $invoice['invoice_number'] ?></td>
                                <td><?= $invoice['customer_name'] ?></td>
                                <td><?= date('d/m/Y', strtotime($invoice['invoice_date'])) ?></td>
                                <td><?= number_format($invoice['total_qty'], 0) ?></td>
                                <td style="font-weight: 500;">Rp <?= number_format($invoice['total_amount'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($invoice['status'] == 'draft'): ?>
                                        <span class="badge badge-warning">Draft</span>
                                    <?php elseif ($invoice['status'] == 'sent'): ?>
                                        <span class="badge badge-info">Dikirim</span>
                                    <?php elseif ($invoice['status'] == 'paid'): ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <a href="<?= base_url('invoices/detail/' . $invoice['id']) ?>" class="btn btn-secondary btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('invoices/edit/' . $invoice['id']) ?>" class="btn btn-secondary btn-sm" style="color: var(--secondary);" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <?php if ($invoice['status'] == 'draft'): ?>
                                            <a href="<?= base_url('invoices/update-status/' . $invoice['id'] . '/sent') ?>" class="btn btn-secondary btn-sm" style="color: var(--info);" title="Tandai Dikirim">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </a>
                                        <?php elseif ($invoice['status'] == 'sent'): ?>
                                            <a href="<?= base_url('invoices/update-status/' . $invoice['id'] . '/paid') ?>" class="btn btn-secondary btn-sm" style="color: var(--success);" title="Tandai Lunas">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu Cepat</h3>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="<?= base_url('invoices/create') ?>" class="btn btn-primary" style="justify-content: flex-start;">
                <i class="fa-solid fa-file-invoice"></i> Buat Invoice Baru
            </a>
            <a href="<?= base_url('customers/create') ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                <i class="fa-solid fa-user-plus"></i> Tambah Pelanggan
            </a>
            <a href="<?= base_url('products/create') ?>" class="btn btn-secondary" style="justify-content: flex-start;">
                <i class="fa-solid fa-circle-plus"></i> Tambah Produk Baru
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
