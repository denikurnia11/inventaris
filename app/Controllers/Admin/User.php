<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data User',
            'user'  => $this->userModel->findAll()
        ];
        return view('user/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah User',
            'validasi' => \Config\Services::validation()
        ];
        return view('user/tambah', $data);
    }

    public function save()
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
                    'min_length' => ' Minimal 4 karakter.',
                ]
            ],
            'role' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Role harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/user/tambah')->withInput();
        }

        $this->userModel->save([
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'email'         => strtolower($this->request->getVar('email')),
            'username'      => $this->request->getVar('username'),
            'password'      => sha1($this->request->getVar('password')),
            'role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/user');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit User',
            'user' => $this->userModel->find($id),
            'validasi' => \Config\Services::validation()
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        // Cek apakah mengganti nilainya
        // Cek apakah mengganti email
        $emailLama = $this->request->getVar('emailLama');
        $emailBaru = strtolower($this->request->getVar('email'));
        if ($emailBaru == $emailLama) {
            $rulesEmail = 'required|valid_email';
        } else {
            $rulesEmail = 'required|is_unique[user.email]|valid_email';
        }
        // Cek apakah mengganti username
        $usernameLama = $this->request->getVar('usernameLama');
        $usernameBaru = strtolower($this->request->getVar('username'));
        if ($usernameBaru == $usernameLama) {
            $rulesUsername = 'required';
        } else {
            $rulesUsername = 'required|is_unique[user.username]';
        }

        //Validasi
        if (!$this->validate([
            'nama_lengkap' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'email' => [
                'rules'  => $rulesEmail,
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.',
                ]
            ],
            'username' => [
                'rules'  => $rulesUsername,
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'is_unique' => 'Username sudah terdaftar.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => ' Minimal 4 karakter.',
                ]
            ],
            'role' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Role harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/user/edit/' . $id)->withInput();
        }

        $this->userModel->update($id, [
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'email'         => $emailBaru,
            'username'      => $usernameBaru,
            'password'      => sha1($this->request->getVar('password')), // Harus Input password lama/baru
            'role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/user');
    }

    public function hapus($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/user');
    }
}
