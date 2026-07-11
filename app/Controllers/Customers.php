<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();
        return view('customers/index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers/create');
    }

    public function store()
    {
        $customerModel = new CustomerModel();

        $rules = [
            'name'           => 'required|min_length[3]',
            'address'        => 'required',
            'contact_person' => 'required',
            'phone'          => 'required',
            'email'          => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $customerModel->insert([
            'name'           => $this->request->getPost('name'),
            'address'        => $this->request->getPost('address'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
        ]);

        return redirect()->to('/customers')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customers')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return view('customers/edit', ['customer' => $customer]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customers')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $rules = [
            'name'           => 'required|min_length[3]',
            'address'        => 'required',
            'contact_person' => 'required',
            'phone'          => 'required',
            'email'          => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $customerModel->update($id, [
            'name'           => $this->request->getPost('name'),
            'address'        => $this->request->getPost('address'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
        ]);

        return redirect()->to('/customers')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $customerModel = new CustomerModel();
        
        try {
            $customerModel->delete($id);
            return redirect()->to('/customers')->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/customers')->with('error', 'Gagal menghapus pelanggan. Data ini mungkin sedang digunakan pada transaksi invoice.');
        }
    }
}
