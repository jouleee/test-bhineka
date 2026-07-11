<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Edit Pelanggan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Edit Pelanggan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$customer = $customer ?? [];
?>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Form Edit Pelanggan</h3>
        <a href="<?= base_url('customers') ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('customers/update/' . $customer['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Nama Pelanggan (Perusahaan/Individu)</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name', $customer['name'])) ?>" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Alamat Lengkap</label>
            <textarea name="address" id="address" class="form-control" required><?= esc(old('address', $customer['address'])) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="contact_person">Contact Person (Up:)</label>
            <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?= esc(old('contact_person', $customer['contact_person'])) ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?= esc(old('phone', $customer['phone'])) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= esc(old('email', $customer['email'])) ?>" required>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('customers') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
