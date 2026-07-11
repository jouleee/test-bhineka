<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Form Tambah User</h3>
        <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('users/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 4 karakter" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="role">Role / Peran</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="Admin" <?= old('role') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Purchasing" <?= old('role') == 'Purchasing' ? 'selected' : '' ?>>Purchasing</option>
                <option value="Finance" <?= old('role') == 'Finance' ? 'selected' : '' ?>>Finance</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan User
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
