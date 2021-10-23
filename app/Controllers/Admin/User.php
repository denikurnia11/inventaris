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
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah User',
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
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
            'email' => [ // Apakah unique ?
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                ]
            ],
            'username' => [
                'rules'  => 'required', // Apakah unique ?
                'errors' => [
                    'required' => 'Username harus diisi.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => ' Minimal 4 karakter.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/user/tambah')->withInput();
        }

        $this->userModel->save([
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'email'         => $this->request->getVar('email'),
            'username'      => $this->request->getVar('username'),
            'password'      => md5($this->request->getVar('password')),
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
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'nama_lengkap' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'email' => [ // Apakah unique ?
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                ]
            ],
            'username' => [
                'rules'  => 'required', // Apakah unique ?
                'errors' => [
                    'required' => 'Username harus diisi.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => ' Minimal 4 karakter.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/user/edit/' . $id)->withInput();
        }

        $this->userModel->update($id, [
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'email'         => $this->request->getVar('email'),
            'username'      => $this->request->getVar('username'),
            'password'      => md5($this->request->getVar('password')), // Harus Input password lama
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
