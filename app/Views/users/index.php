<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$users = $users ?? [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna Sistem</h3>
        <?php if (session()->get('role') === 'Admin'): ?>
            <a href="<?= base_url('users/create') ?>" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Tambah User
            </a>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Dibuat Pada</th>
                    <?php if (session()->get('role') === 'Admin'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="<?= (session()->get('role') === 'Admin') ? 6 : 5 ?>" style="text-align: center; color: var(--text-muted);">Belum ada data user.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 600;"><?= esc($user['name']) ?></td>
                            <td><?= esc($user['username']) ?></td>
                            <td>
                                <?php if ($user['role'] == 'Admin'): ?>
                                    <span class="badge badge-danger">Admin</span>
                                <?php elseif ($user['role'] == 'Purchasing'): ?>
                                    <span class="badge badge-info">Purchasing</span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?= esc($user['role']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <?php if (session()->get('role') === 'Admin'): ?>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-secondary btn-sm" style="color: var(--secondary);" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <?php if ($user['id'] != session()->get('id')): ?>
                                            <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
