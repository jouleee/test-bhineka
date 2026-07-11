<?php
$invoice = $invoice ?? [];
$settings = $settings ?? [];
$items = $items ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Faktur - <?= esc($invoice['invoice_number']) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
            color: #000000;
            padding: 20px;
            font-size: 11pt;
        }

        .invoice-print-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000000;
            padding: 24px;
        }

        .invoice-header-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .company-info {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .company-info h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .company-info p {
            font-size: 9pt;
            line-height: 1.3;
            color: #333333;
        }

        .customer-recipient {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            padding-left: 20px;
        }

        .customer-recipient .title-label {
            font-size: 10pt;
            color: #333333;
            margin-bottom: 2px;
        }

        .customer-recipient h3 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .customer-recipient p {
            font-size: 9pt;
            line-height: 1.3;
        }

        .invoice-number-line {
            font-size: 11pt;
            font-weight: bold;
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
            padding: 6px 10px;
            font-size: 10pt;
        }

        .invoice-mockup-table th {
            background-color: #e5e7eb !important; /* light grey */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
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
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .sig-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .sig-block-left {
            text-align: left;
            padding-left: 20px;
        }

        .sig-block-right {
            text-align: right;
            padding-right: 20px;
        }

        .sig-placeholder {
            height: 70px;
        }

        .signer-name {
            font-weight: bold;
        }

        @media print {
            @page {
                size: auto;
                margin: 0;
            }
            body {
                padding: 1.5cm;
            }
            .invoice-print-container {
                border: 2px solid #000000;
                box-shadow: none;
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
</head>
<body>

<div class="invoice-print-container">
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
            <div class="sig-placeholder"></div>
            <div class="signer-name"><?= esc($invoice['user_name']) ?></div>
        </div>
        
        <div class="sig-block sig-block-right">
            <div><?= esc($invoice['signed_place']) ?>, <?= date('d F Y', strtotime($invoice['invoice_date'])) ?></div>
            <div class="sig-placeholder"></div>
            <div class="signer-name"><?= esc($invoice['customer_signer_name']) ?></div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
