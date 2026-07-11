<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen Produk<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Barang (Products)<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$products = $products ?? [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Produk / Barang</h3>
        <a href="<?= base_url('products/create') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-circle-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Satuan (Unit)</th>
                    <th>Harga Default</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data produk.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($products as $product): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><code style="font-weight: 700; font-size: 0.9rem; color: var(--secondary); background-color: rgba(227, 51, 32, 0.05); padding: 2px 6px; border-radius: 4px;"><?= esc($product['code']) ?></code></td>
                            <td style="font-weight: 600;"><?= esc($product['name']) ?></td>
                            <td><?= esc($product['unit']) ?></td>
                            <td style="font-weight: 500;">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?= base_url('products/edit/' . $product['id']) ?>" class="btn btn-secondary btn-sm" style="color: var(--secondary);" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="<?= base_url('products/delete/' . $product['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus">
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
