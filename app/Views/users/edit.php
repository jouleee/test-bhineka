<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$user = $user ?? [];
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Form Edit User</h3>
        <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name', $user['name'])) ?>" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= esc(old('username', $user['username'])) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password (Baru)</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
        </div>

        <div class="form-group">
            <label class="form-label" for="role">Role / Peran</label>
            <select name="role" id="role" class="form-control" required>
                <option value="Admin" <?= old('role', $user['role']) == 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Purchasing" <?= old('role', $user['role']) == 'Purchasing' ? 'selected' : '' ?>>Purchasing</option>
                <option value="Finance" <?= old('role', $user['role']) == 'Finance' ? 'selected' : '' ?>>Finance</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
