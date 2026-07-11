<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'id'        => $user['id'],
                'name'      => $user['name'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true,
            ];
            session()->set($sessionData);
            return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . $user['name'] . '!');
        }

        return redirect()->back()->withInput()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
