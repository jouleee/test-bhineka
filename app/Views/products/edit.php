<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Edit Produk<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Edit Produk<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">Form Edit Produk</h3>
        <a href="<?= base_url('products') ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('products/update/' . $product['id']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="code">Kode Produk (Unique)</label>
            <input type="text" name="code" id="code" class="form-control" value="<?= esc(old('code', $product['code'])) ?>" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nama Produk / Barang</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name', $product['name'])) ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="unit">Satuan (Unit)</label>
                <input type="text" name="unit" id="unit" class="form-control" value="<?= esc(old('unit', $product['unit'])) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="price_display">Harga Default (Terbaru)</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <span style="position: absolute; left: 14px; font-weight: 600; color: var(--text-muted); font-size: 0.875rem; user-select: none;">Rp</span>
                    <input type="text" id="price_display" class="form-control" style="padding-left: 40px;" placeholder="150.000" required>
                    <input type="hidden" name="price" id="price" value="<?= esc(old('price', $product['price'])) ?>">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('products') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const priceDisplay = document.getElementById('price_display');
        const priceInput = document.getElementById('price');

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function parseNumber(str) {
            return str.replace(/\D/g, "");
        }

        // Initialize formatted value if old value exists
        if (priceInput.value) {
            priceDisplay.value = formatNumber(priceInput.value);
        }

        priceDisplay.addEventListener('input', function() {
            let cleanVal = parseNumber(this.value);
            priceInput.value = cleanVal;
            this.value = cleanVal ? formatNumber(cleanVal) : '';
        });
    });
</script>
<?= $this->endSection() ?>
