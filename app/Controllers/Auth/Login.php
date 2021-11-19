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
            'title'   => 'Form Login'
        ];
        return json_encode($data);
    }

    public function cek()
    {
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
