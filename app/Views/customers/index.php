<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen Pelanggan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pelanggan (Customers)<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$customers = $customers ?? [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pelanggan PT. Bhinneka Sangkuriang Transport</h3>
        <a href="<?= base_url('customers/create') ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-user-plus"></i> Tambah Pelanggan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Contact Person (Up)</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted);">Belum ada data pelanggan.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600;"><?= esc($customer['name']) ?></td>
                            <td><?= esc($customer['address']) ?></td>
                            <td><?= esc($customer['contact_person']) ?></td>
                            <td><?= esc($customer['phone']) ?></td>
                            <td><?= esc($customer['email']) ?></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?= base_url('customers/edit/' . $customer['id']) ?>" class="btn btn-secondary btn-sm" style="color: var(--secondary);" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="<?= base_url('customers/delete/' . $customer['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')" title="Hapus">
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
