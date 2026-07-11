<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Profil Perusahaan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Profil Perusahaan Penerbit Invoice<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$setting = $setting ?? [];
?>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Edit Profil Perusahaan</h3>
    </div>
    
    <form action="<?= base_url('settings/update') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label class="form-label" for="company_name">Nama Perusahaan</label>
            <input type="text" name="company_name" id="company_name" class="form-control" value="<?= esc($setting['company_name']) ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="company_address">Alamat Perusahaan</label>
            <textarea name="company_address" id="company_address" class="form-control" required><?= esc($setting['company_address']) ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="company_phone">Nomor Telepon</label>
                <input type="text" name="company_phone" id="company_phone" class="form-control" value="<?= esc($setting['company_phone']) ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="company_email">Email Perusahaan</label>
                <input type="email" name="company_email" id="company_email" class="form-control" value="<?= esc($setting['company_email']) ?>" required>
            </div>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
