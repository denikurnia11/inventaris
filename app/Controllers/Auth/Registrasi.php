<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Registrasi extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Form Registrasi',
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function create()
    {
        //Validasi
        if (!$this->validate([
            'nama_lengkap' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.',
                ]
            ],
            'username' => [
                'rules'  => 'required|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'is_unique' => 'Username sudah terdaftar.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => 'Minimal 4 karakter.',
                ]
            ],
            'cpassword' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required'   => 'Confirm Password harus diisi.',
                    'matches' => 'Confirm Password tidak valid.',
                ]
            ],

        ])) {
            // Redirect
            return redirect()->to(base_url() . '/auth/registrasi')->withInput();
        }

        $this->userModel->save([
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'email'         => strtolower($this->request->getVar('email')),
            'username'      => strtolower($this->request->getVar('username')),
            'password'      => sha1($this->request->getVar('password')),
            'role'          => 'user',
        ]);

        session()->setFlashdata('pesan', 'Akun Berhasil Dibuat.');
        return redirect()->to(base_url() . '/auth/login');
    }
}
