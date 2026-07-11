<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\SettingModel;

class Invoices extends BaseController
{
    public function index()
    {
        $invoiceModel = new InvoiceModel();
        $invoices = $invoiceModel->getInvoiceDetails();
        return view('invoices/index', ['invoices' => $invoices]);
    }

    public function create()
    {
        $customerModel = new CustomerModel();
        $userModel = new UserModel();
        $productModel = new ProductModel();

        $data = [
            'customers' => $customerModel->findAll(),
            'users'     => $userModel->findAll(), // allow selection of any user as signer
            'products'  => $productModel->findAll()
        ];

        return view('invoices/create', $data);
    }

    public function store()
    {
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();
        $productModel = new ProductModel();

        $rules = [
            'invoice_number'       => 'required|is_unique[invoices.invoice_number]',
            'customer_id'          => 'required',
            'invoice_date'         => 'required|valid_date',
            'signed_place'         => 'required',
            'purchasing_user_id'   => 'required',
            'customer_signer_name' => 'required',
            'status'               => 'required',
            'products'             => 'required' // array of product items
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $itemsInput = $this->request->getPost('products');
        if (empty($itemsInput) || !is_array($itemsInput)) {
            return redirect()->back()->withInput()->with('error', 'Transaksi harus memiliki minimal 1 produk.');
        }

        // Start Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Insert Invoice Header
        $invoiceData = [
            'invoice_number'       => $this->request->getPost('invoice_number'),
            'customer_id'          => $this->request->getPost('customer_id'),
            'invoice_date'         => $this->request->getPost('invoice_date'),
            'signed_place'         => $this->request->getPost('signed_place'),
            'purchasing_user_id'   => $this->request->getPost('purchasing_user_id'),
            'customer_signer_name' => $this->request->getPost('customer_signer_name'),
            'status'               => $this->request->getPost('status'),
            'total_qty'            => 0,
            'total_amount'         => 0
        ];

        $invoiceModel->insert($invoiceData);
        $invoiceId = $invoiceModel->getInsertID();

        // 2. Loop through products, fetch snapshots, insert items, and calculate totals
        $totalQty = 0;
        $totalAmount = 0;

        foreach ($itemsInput as $item) {
            if (empty($item['product_id']) || empty($item['qty']) || $item['qty'] <= 0) {
                continue;
            }

            $product = $productModel->find($item['product_id']);
            if (!$product) {
                continue;
            }

            $qty = floatval($item['qty']);
            $price = floatval($item['price'] ?? $product['price']);
            $totalPrice = $qty * $price;

            $totalQty += $qty;
            $totalAmount += $totalPrice;

            $invoiceItemModel->insert([
                'invoice_id'   => $invoiceId,
                'product_id'   => $product['id'],
                'product_code' => $product['code'],
                'product_name' => $product['name'],
                'unit'         => $product['unit'],
                'qty'          => $qty,
                'price'        => $price,
                'total_price'  => $totalPrice
            ]);
        }

        // 3. Update Invoice Header totals
        $invoiceModel->update($invoiceId, [
            'total_qty'    => $totalQty,
            'total_amount' => $totalAmount
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi invoice.');
        }

        return redirect()->to('/invoices')->with('success', 'Transaksi Invoice berhasil disimpan.');
    }

    public function edit($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();
        $customerModel = new CustomerModel();
        $userModel = new UserModel();
        $productModel = new ProductModel();

        $invoice = $invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoices')->with('error', 'Invoice tidak ditemukan.');
        }

        $data = [
            'invoice'      => $invoice,
            'invoiceItems' => $invoiceItemModel->where('invoice_id', $id)->findAll(),
            'customers'    => $customerModel->findAll(),
            'users'        => $userModel->findAll(),
            'products'     => $productModel->findAll()
        ];

        return view('invoices/edit', $data);
    }

    public function update($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();
        $productModel = new ProductModel();

        $invoice = $invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoices')->with('error', 'Invoice tidak ditemukan.');
        }

        $rules = [
            'invoice_number'       => "required|is_unique[invoices.invoice_number,id,{$id}]",
            'customer_id'          => 'required',
            'invoice_date'         => 'required|valid_date',
            'signed_place'         => 'required',
            'purchasing_user_id'   => 'required',
            'customer_signer_name' => 'required',
            'status'               => 'required',
            'products'             => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $itemsInput = $this->request->getPost('products');
        if (empty($itemsInput) || !is_array($itemsInput)) {
            return redirect()->back()->withInput()->with('error', 'Transaksi harus memiliki minimal 1 produk.');
        }

        // Start Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update Invoice Header
        $invoiceData = [
            'invoice_number'       => $this->request->getPost('invoice_number'),
            'customer_id'          => $this->request->getPost('customer_id'),
            'invoice_date'         => $this->request->getPost('invoice_date'),
            'signed_place'         => $this->request->getPost('signed_place'),
            'purchasing_user_id'   => $this->request->getPost('purchasing_user_id'),
            'customer_signer_name' => $this->request->getPost('customer_signer_name'),
            'status'               => $this->request->getPost('status')
        ];

        $invoiceModel->update($id, $invoiceData);

        // 2. Delete existing items
        $invoiceItemModel->where('invoice_id', $id)->delete();

        // 3. Insert new items and recalculate totals
        $totalQty = 0;
        $totalAmount = 0;

        foreach ($itemsInput as $item) {
            if (empty($item['product_id']) || empty($item['qty']) || $item['qty'] <= 0) {
                continue;
            }

            $product = $productModel->find($item['product_id']);
            if (!$product) {
                continue;
            }

            $qty = floatval($item['qty']);
            $price = floatval($item['price'] ?? $product['price']);
            $totalPrice = $qty * $price;

            $totalQty += $qty;
            $totalAmount += $totalPrice;

            $invoiceItemModel->insert([
                'invoice_id'   => $id,
                'product_id'   => $product['id'],
                'product_code' => $product['code'],
                'product_name' => $product['name'],
                'unit'         => $product['unit'],
                'qty'          => $qty,
                'price'        => $price,
                'total_price'  => $totalPrice
            ]);
        }

        // 4. Update Invoice Header totals
        $invoiceModel->update($id, [
            'total_qty'    => $totalQty,
            'total_amount' => $totalAmount
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui transaksi invoice.');
        }

        return redirect()->to('/invoices')->with('success', 'Transaksi Invoice berhasil diperbarui.');
    }

    public function delete($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if (!$invoice) {
            return redirect()->to('/invoices')->with('error', 'Invoice tidak ditemukan.');
        }

        $invoiceModel->delete($id);

        return redirect()->to('/invoices')->with('success', 'Invoice berhasil dihapus.');
    }

    public function detail($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();
        $settingModel = new SettingModel();

        $invoice = $invoiceModel->getInvoiceDetails($id);
        if (!$invoice) {
            return redirect()->to('/invoices')->with('error', 'Invoice tidak ditemukan.');
        }

        $items = $invoiceItemModel->where('invoice_id', $id)->findAll();
        $settings = $settingModel->find(1);

        $data = [
            'invoice'  => $invoice,
            'items'    => $items,
            'settings' => $settings
        ];

        return view('invoices/detail', $data);
    }

    public function print($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();
        $settingModel = new SettingModel();

        $invoice = $invoiceModel->getInvoiceDetails($id);
        if (!$invoice) {
            return redirect()->to('/invoices')->with('error', 'Invoice tidak ditemukan.');
        }

        $items = $invoiceItemModel->where('invoice_id', $id)->findAll();
        $settings = $settingModel->find(1);

        $data = [
            'invoice'  => $invoice,
            'items'    => $items,
            'settings' => $settings
        ];

        return view('invoices/print', $data);
    }

    public function updateStatus($id, $status)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice tidak ditemukan.');
        }

        $allowedStatuses = ['draft', 'sent', 'paid', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $invoiceModel->update($id, ['status' => $status]);

        $statusLabels = [
            'draft'     => 'Draft',
            'sent'      => 'Dikirim',
            'paid'      => 'Lunas',
            'cancelled' => 'Dibatalkan'
        ];

        return redirect()->back()->with('success', 'Status Faktur #' . $invoice['invoice_number'] . ' berhasil diubah menjadi ' . $statusLabels[$status] . '.');
    }
}
