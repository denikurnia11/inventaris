<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Form Login',
            'validasi' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }

    public function cek()
    {
        if (!$this->validate([
            'username' => [
                'rules'  => 'required|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => 'Minimal 4 karakter.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->back()->withInput();
        }

        // Ambil data dari form
        $data = $this->request->getVar();
        // Ambil data user di database yang emailnya sama 
        $dataUser = $this->userModel->where('email', $data['email'])->first();

        if (!$dataUser) {
            // Jika Email tidak ditemukan, balikkan ke halaman login
            session()->setFlashdata('pesan', 'Email tidak ditemukan');
            // Redirect ke login
            return redirect()->to('/');
        }
        // Cek password
        // Jika salah arahkan lagi ke halaman login
        if (sha1($data['password']) !== $dataUser['password']) {
            session()->setFlashdata('pesan', 'Password salah');
            // Redirect ke login
            return redirect()->to('/');
        } else {
            // Jika benar, arahkan user masuk ke aplikasi 
            $sessLogin = [
                'idUser' => $dataUser['id_user'],
                'nama' => $dataUser['nama_lengkap'],
                'username' => $dataUser['username'],
                'email' => $dataUser['email'],
                'role' => $dataUser['role']
            ];
            session()->set($sessLogin);
            // Otomatis ter-redirect oleh filter
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
