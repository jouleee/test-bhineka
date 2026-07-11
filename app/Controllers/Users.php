<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('users/index', ['users' => $users]);
    }

    public function create()
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/users')->with('error', 'Akses ditolak: Hanya Admin yang dapat mengelola data user.');
        }
        return view('users/create');
    }

    public function store()
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/users')->with('error', 'Akses ditolak: Hanya Admin yang dapat mengelola data user.');
        }

        $userModel = new UserModel();

        // Simple validation
        $rules = [
            'name'     => 'required|min_length[3]',
            'username' => 'required|is_unique[users.username]|min_length[3]',
            'password' => 'required|min_length[4]',
            'role'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $userModel->insert($data);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/users')->with('error', 'Akses ditolak: Hanya Admin yang dapat mengelola data user.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        return view('users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/users')->with('error', 'Akses ditolak: Hanya Admin yang dapat mengelola data user.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name'     => 'required|min_length[3]',
            'username' => "required|is_unique[users.username,id,{$id}]|min_length[3]",
            'role'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: mohon periksa isian Anda.');
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/users')->with('error', 'Akses ditolak: Hanya Admin yang dapat mengelola data user.');
        }

        $userModel = new UserModel();
        
        // Prevent deleting yourself
        if ($id == session()->get('id')) {
            return redirect()->to('/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
    }
}
