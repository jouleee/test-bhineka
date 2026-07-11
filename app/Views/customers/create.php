<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Tambah Pelanggan Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Tambah Pelanggan Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Pelanggan</h3>
        <a href="<?= base_url('customers') ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('customers/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Nama Pelanggan (Perusahaan/Individu)</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" placeholder="Contoh: PT. SENTOSA" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Alamat Lengkap</label>
            <textarea name="address" id="address" class="form-control" placeholder="Contoh: Jl. Bypass Cirebon" required><?= old('address') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="contact_person">Contact Person (Up:)</label>
            <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?= old('contact_person') ?>" placeholder="Contoh: Robert" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?= old('phone') ?>" placeholder="Contoh: 0231-1234567" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" placeholder="Contoh: robert@sentosa.co.id" required>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('customers') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pelanggan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
