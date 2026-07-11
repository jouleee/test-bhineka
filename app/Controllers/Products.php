<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();
        return view('products/index', ['products' => $products]);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $productModel = new ProductModel();

        $rules = [
            'code'  => 'required|is_unique[products.code]|min_length[2]',
            'name'  => 'required|min_length[3]',
            'unit'  => 'required',
            'price' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $productModel->insert([
            'code'  => strtoupper($this->request->getPost('code')),
            'name'  => $this->request->getPost('name'),
            'unit'  => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price'),
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        return view('products/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'code'  => "required|is_unique[products.code,id,{$id}]|min_length[2]",
            'name'  => 'required|min_length[3]',
            'unit'  => 'required',
            'price' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $productModel->update($id, [
            'code'  => strtoupper($this->request->getPost('code')),
            'name'  => $this->request->getPost('name'),
            'unit'  => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price'),
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();

        try {
            $productModel->delete($id);
            return redirect()->to('/products')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/products')->with('error', 'Gagal menghapus produk. Data ini mungkin sedang digunakan pada detail transaksi invoice.');
        }
    }
}
