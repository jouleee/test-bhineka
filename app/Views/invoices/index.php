<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Transaksi Invoice<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Transaksi Invoice / Faktur<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$invoices = $invoices ?? [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Transaksi</h3>
        <a href="<?= base_url('invoices/create') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-file-invoice"></i> Buat Invoice Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Faktur</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Faktur</th>
                    <th>Total Jumlah (Qty)</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($invoices)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted);">Belum ada data transaksi invoice.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600;"><?= esc($invoice['invoice_number']) ?></td>
                            <td><?= esc($invoice['customer_name']) ?></td>
                            <td><?= date('d/m/Y', strtotime($invoice['invoice_date'])) ?></td>
                            <td><?= number_format($invoice['total_qty'], 0) ?></td>
                            <td style="font-weight: 500;">Rp <?= number_format($invoice['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($invoice['status'] == 'draft'): ?>
                                    <span class="badge badge-warning">Draft</span>
                                <?php elseif ($invoice['status'] == 'sent'): ?>
                                    <span class="badge badge-info">Sent</span>
                                <?php elseif ($invoice['status'] == 'paid'): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Cancelled</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 4px;">
                                    <a href="<?= base_url('invoices/detail/' . $invoice['id']) ?>" class="btn btn-secondary btn-sm" title="Lihat Detail Faktur">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    <a href="<?= base_url('invoices/print/' . $invoice['id']) ?>" target="_blank" class="btn btn-secondary btn-sm" title="Cetak Faktur">
                                        <i class="fa-solid fa-print"></i> Cetak
                                    </a>
                                    <a href="<?= base_url('invoices/edit/' . $invoice['id']) ?>" class="btn btn-secondary btn-sm" style="color: var(--secondary);" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <?php if ($invoice['status'] == 'draft'): ?>
                                        <a href="<?= base_url('invoices/update-status/' . $invoice['id'] . '/sent') ?>" class="btn btn-secondary btn-sm" style="color: var(--info);" title="Tandai Dikirim">
                                            <i class="fa-solid fa-paper-plane"></i> Kirim
                                        </a>
                                    <?php elseif ($invoice['status'] == 'sent'): ?>
                                        <a href="<?= base_url('invoices/update-status/' . $invoice['id'] . '/paid') ?>" class="btn btn-secondary btn-sm" style="color: var(--success);" title="Tandai Lunas">
                                            <i class="fa-solid fa-circle-check"></i> Lunas
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('invoices/delete/' . $invoice['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus invoice transaksi ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
