<?php
$invoice = $invoice ?? [];
$settings = $settings ?? [];
$items = $items ?? [];
?>

<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Detail Invoice - <?= esc($invoice['invoice_number']) ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>Detail Transaksi Invoice<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Styling for the exact mockup reproduction */
    .invoice-mockup-wrapper {
        background-color: var(--primary);
        padding: 40px;
        border-radius: 8px;
        box-shadow: var(--shadow-md);
        margin-bottom: 24px;
        display: flex;
        justify-content: center;
    }

    .invoice-box {
        width: 100%;
        max-width: 800px;
        border: 3px solid #000000;
        padding: 30px;
        background-color: #ffffff;
        color: #000000;
        font-family: Arial, Helvetica, sans-serif; /* matches clean print font */
        box-sizing: border-box;
    }

    .invoice-header-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        margin-bottom: 20px;
        align-items: start;
    }

    .company-info h2 {
        font-size: 1.35rem;
        font-weight: bold;
        margin-bottom: 6px;
        color: #000000;
        font-family: Arial, sans-serif;
    }

    .company-info p {
        font-size: 0.8rem;
        line-height: 1.3;
        color: #333333;
    }

    .customer-recipient {
        text-align: left;
        font-size: 0.95rem;
        padding-left: 20px;
    }

    .customer-recipient .title-label {
        font-size: 0.9rem;
        color: #333333;
        margin-bottom: 2px;
    }

    .customer-recipient h3 {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .customer-recipient p {
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .invoice-number-line {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 12px;
        border-bottom: 1px solid #000000;
        padding-bottom: 4px;
    }

    /* Mockup Table Details */
    .invoice-mockup-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .invoice-mockup-table th, 
    .invoice-mockup-table td {
        border: 1px solid #000000;
        padding: 8px 12px;
        font-size: 0.9rem;
        color: #000000;
    }

    .invoice-mockup-table th {
        background-color: #e5e7eb; /* Light grey/silver */
        font-weight: bold;
        text-align: center;
    }

    .invoice-mockup-table td.center {
        text-align: center;
    }

    .invoice-mockup-table td.right {
        text-align: right;
    }

    .invoice-mockup-table tr.total-row td {
        font-weight: bold;
    }

    /* Signatures Section */
    .invoice-signatures-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-top: 40px;
        font-size: 0.9rem;
    }

    .sig-block {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 110px;
    }

    .sig-block-left {
        align-items: flex-start;
        padding-left: 20px;
    }

    .sig-block-right {
        align-items: flex-end;
        padding-right: 20px;
        text-align: right;
    }

    .signer-name {
        font-weight: bold;
        text-decoration: none;
        border-bottom: none;
    }

    .actions-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-box, .invoice-box * {
            visibility: visible;
        }
        .invoice-box {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: 2px solid #000000;
        }
        .actions-bar {
            display: none !important;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
        .invoice-signatures-grid {
            page-break-inside: avoid;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="actions-bar">
    <a href="<?= base_url('invoices') ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
    </a>
    <a href="<?= base_url('invoices/print/' . $invoice['id']) ?>" target="_blank" class="btn btn-primary">
        <i class="fa-solid fa-print"></i> Cetak Invoice / Faktur
    </a>
    <a href="<?= base_url('invoices/edit/' . $invoice['id']) ?>" class="btn btn-secondary" style="color: var(--secondary);">
        <i class="fa-solid fa-pen-to-square"></i> Edit Faktur
    </a>
</div>

<div class="invoice-mockup-wrapper">
    <div class="invoice-box">
        <!-- Header Info PT & Client -->
        <div class="invoice-header-grid">
            <div class="company-info">
                <h2><?= esc($settings['company_name']) ?></h2>
                <p><?= nl2br(esc($settings['company_address'])) ?></p>
                <p>Telp: <?= esc($settings['company_phone']) ?> | Email: <?= esc($settings['company_email']) ?></p>
            </div>
            
            <div class="customer-recipient">
                <div class="title-label">Kepada Yth :</div>
                <h3><?= esc($invoice['customer_name']) ?></h3>
                <p><?= esc($invoice['customer_address']) ?></p>
                <p>Up : <?= esc($invoice['customer_signer_name']) ?></p>
            </div>
        </div>

        <!-- Invoice Number -->
        <div class="invoice-number-line">
            No. Faktur : <?= esc($invoice['invoice_number']) ?>
        </div>

        <!-- Items Table -->
        <table class="invoice-mockup-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Kode</th>
                    <th style="width: 35%;">Nama</th>
                    <th style="width: 12%;">Satuan</th>
                    <th style="width: 13%;">Jumlah</th>
                    <th style="width: 15%;">Harga</th>
                    <th style="width: 15%;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sumUnitPrice = 0; 
                foreach ($items as $item): 
                    $sumUnitPrice += floatval($item['price']);
                ?>
                    <tr>
                        <td class="center"><?= esc($item['product_code']) ?></td>
                        <td><?= esc($item['product_name']) ?></td>
                        <td class="center"><?= esc($item['unit']) ?></td>
                        <td class="center"><?= number_format($item['qty'], 0, ',', '.') ?></td>
                        <td class="right"><?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td class="right"><?= number_format($item['total_price'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <tr class="total-row">
                    <td></td>
                    <td class="center">TOTAL</td>
                    <td></td>
                    <td class="center"><?= number_format($invoice['total_qty'], 0, ',', '.') ?></td>
                    <td class="right"><?= number_format($sumUnitPrice, 0, ',', '.') ?></td>
                    <td class="right"><?= number_format($invoice['total_amount'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures and Date Place -->
        <div class="invoice-signatures-grid">
            <div class="sig-block sig-block-left">
                <div><?= esc($invoice['user_role'] ?? 'Purchasing') ?></div>
                <div class="signer-name"><?= esc($invoice['user_name']) ?></div>
            </div>
            
            <div class="sig-block sig-block-right">
                <div><?= esc($invoice['signed_place']) ?>, <?= date('d F Y', strtotime($invoice['invoice_date'])) ?></div>
                <div class="signer-name"><?= esc($invoice['customer_signer_name']) ?></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
