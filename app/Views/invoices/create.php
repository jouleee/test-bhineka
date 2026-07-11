<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Buat Invoice Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Buat Invoice Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$customers = $customers ?? [];
$users = $users ?? [];
$products = $products ?? [];
?>

<form action="<?= base_url('invoices/store') ?>" method="POST" id="invoice-form">
    <?= csrf_field() ?>

    <div class="invoice-builder-grid">
        <!-- Section: Invoice Header Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Header Invoice</h3>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="invoice_number">Nomor Faktur / Invoice</label>
                <input type="text" name="invoice_number" id="invoice_number" class="form-control" placeholder="Contoh: 034/TD/XI/2024" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="customer_id">Pelanggan</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= $customer['id'] ?>"><?= esc($customer['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="invoice_date">Tanggal Faktur</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="draft">Draft</option>
                        <option value="sent">Dikirim (Sent)</option>
                        <option value="paid">Lunas (Paid)</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="signed_place">Tempat Penandatanganan</label>
                    <input type="text" name="signed_place" id="signed_place" class="form-control" value="Cirebon" placeholder="Contoh: Cirebon" required>
                </div>
            </div>
        </div>

        <!-- Section: Invoice Signers Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Penandatangan</h3>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="purchasing_user_id">Penandatangan Pihak 1 (Purchasing)</label>
                <select name="purchasing_user_id" id="purchasing_user_id" class="form-control" required>
                    <option value="">-- Pilih Penandatangan --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= ($user['role'] == 'Purchasing') ? 'selected' : '' ?>>
                            <?= esc($user['name']) ?> (<?= esc($user['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="customer_signer_name">Penandatangan Pihak 2 (Penerima Pelanggan)</label>
                <input type="text" name="customer_signer_name" id="customer_signer_name" class="form-control" placeholder="Contoh: Robert" required>
            </div>
        </div>
    </div>

    <!-- Section: Invoice Line Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Item Transaksi (Faktur)</h3>
            <button type="button" class="btn btn-secondary btn-sm" id="btn-add-item">
                <i class="fa-solid fa-plus"></i> Tambah Item
            </button>
        </div>

        <div class="table-responsive">
            <table class="table" id="items-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Kode / Nama Produk</th>
                        <th style="width: 15%;" class="text-center">Satuan</th>
                        <th style="width: 15%;" class="text-center">Jumlah (Qty)</th>
                        <th style="width: 20%;" class="text-right">Harga Satuan (Rp)</th>
                        <th style="width: 20%;" class="text-right">Total Harga (Rp)</th>
                        <th style="width: 5%;" class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody id="items-tbody">
                    <!-- Dynamic Rows Will Be Added Here -->
                </tbody>
                <tfoot>
                    <tr style="background-color: #f8fafc; font-weight: 700;">
                        <td colspan="2" class="text-right">GRAND TOTAL:</td>
                        <td id="grand-total-qty" class="text-center">0</td>
                        <td></td>
                        <td id="grand-total-amount" class="text-right">Rp 0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="<?= base_url('invoices') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi
            </button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Embed products data for client-side search lookup
    const productsData = <?= json_encode($products) ?>;
    let rowIndex = 0;

    // Helper function to render a new line item row
    function addRow() {
        const tbody = document.getElementById('items-tbody');
        const tr = document.createElement('tr');
        tr.id = `row-${rowIndex}`;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        productsData.forEach(p => {
            productOptions += `<option value="${p.id}">${p.code} - ${p.name}</option>`;
        });

        tr.innerHTML = `
            <td>
                <select name="products[${rowIndex}][product_id]" class="form-control product-select" data-row="${rowIndex}" required>
                    ${productOptions}
                </select>
            </td>
            <td class="text-center">
                <input type="text" class="form-control product-unit text-center" id="unit-${rowIndex}" readonly placeholder="Satuan">
            </td>
            <td class="text-center">
                <input type="number" name="products[${rowIndex}][qty]" class="form-control product-qty text-center" id="qty-${rowIndex}" data-row="${rowIndex}" min="1" step="any" placeholder="0" required>
            </td>
            <td class="text-right">
                <input type="number" name="products[${rowIndex}][price]" class="form-control product-price text-right" id="price-${rowIndex}" data-row="${rowIndex}" min="0" placeholder="0" required>
            </td>
            <td class="text-right">
                <input type="text" class="form-control product-subtotal text-right" id="subtotal-${rowIndex}" readonly placeholder="Rp 0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-delete-row" data-row="${rowIndex}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        rowIndex++;
        
        // Add event listeners for new elements
        bindEvents();
    }

    function bindEvents() {
        // Product change dropdown
        document.querySelectorAll('.product-select').forEach(select => {
            select.onchange = function() {
                const row = this.getAttribute('data-row');
                const productId = this.value;
                const product = productsData.find(p => p.id == productId);

                if (product) {
                    document.getElementById(`unit-${row}`).value = product.unit;
                    document.getElementById(`price-${row}`).value = Math.round(product.price);
                    if (!document.getElementById(`qty-${row}`).value) {
                        document.getElementById(`qty-${row}`).value = 1;
                    }
                } else {
                    document.getElementById(`unit-${row}`).value = '';
                    document.getElementById(`price-${row}`).value = '';
                }
                calculateRowTotal(row);
            };
        });

        // Qty and Price keyups
        document.querySelectorAll('.product-qty, .product-price').forEach(input => {
            input.oninput = function() {
                const row = this.getAttribute('data-row');
                calculateRowTotal(row);
            };
        });

        // Delete row buttons
        document.querySelectorAll('.btn-delete-row').forEach(btn => {
            btn.onclick = function() {
                const row = this.getAttribute('data-row');
                document.getElementById(`row-${row}`).remove();
                calculateGrandTotal();
            };
        });
    }

    function calculateRowTotal(row) {
        const qty = parseFloat(document.getElementById(`qty-${row}`).value) || 0;
        const price = parseFloat(document.getElementById(`price-${row}`).value) || 0;
        const total = qty * price;
        
        document.getElementById(`subtotal-${row}`).value = formatRupiah(total);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotalQty = 0;
        let grandTotalAmount = 0;

        document.querySelectorAll('.product-qty').forEach(qtyInput => {
            const row = qtyInput.getAttribute('data-row');
            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(document.getElementById(`price-${row}`).value) || 0;

            grandTotalQty += qty;
            grandTotalAmount += (qty * price);
        });

        document.getElementById('grand-total-qty').innerText = grandTotalQty;
        document.getElementById('grand-total-amount').innerText = formatRupiah(grandTotalAmount);
    }

    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    // Add first empty row on page load
    document.addEventListener('DOMContentLoaded', () => {
        addRow();
        
        document.getElementById('btn-add-item').onclick = function() {
            addRow();
        };

        // Form validation on submit: check if at least one item is filled
        document.getElementById('invoice-form').onsubmit = function(e) {
            const rowCount = document.querySelectorAll('#items-tbody tr').length;
            if (rowCount === 0) {
                alert('Silakan tambah minimal satu item produk ke dalam transaksi.');
                e.preventDefault();
                return false;
            }
        };
    });
</script>
<?= $this->endSection() ?>
