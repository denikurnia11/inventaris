<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamModel;
use App\Models\UserModel;

class Peminjam extends BaseController
{
    protected $peminjamModel, $userModel;
    public function __construct()
    {
        $this->peminjamModel = new PeminjamModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Peminjam',
            'peminjam' => $this->peminjamModel->getData()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Peminjam',
            'user'     => $this->userModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'id_user' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'User harus diisi.'
                ]
            ],
            'nama_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'nama_instansi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama instansi harus diisi.'
                ]
            ],
            'no_hp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjam/tambah')->withInput();
        }

        $this->peminjamModel->save([
            'id_user'       => $this->request->getVar('id_user'),
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'nama_instansi' => $this->request->getVar('nama_instansi'),
            'no_hp'          => $this->request->getVar('no_hp'),
            'status'          => $this->request->getVar('no_hp'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/peminjam');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Form Edit Peminjam',
            'peminjam'   => $this->peminjamModel->find($id),
            'user'       => $this->userModel->findAll(), // Dropdown
            'validasi'   => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'id_user' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'User harus diisi.'
                ]
            ],
            'nama_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'nama_instansi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama instansi harus diisi.'
                ]
            ],
            'no_hp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjam/edit' . $id)->withInput();
        }

        $this->peminjamModel->update($id, [
            'id_user'       => $this->request->getVar('id_user'),
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'nama_instansi' => $this->request->getVar('nama_instansi'),
            'no_hp'         => $this->request->getVar('no_hp'),
            'status'        => $this->request->getVar('no_hp'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/peminjam');
    }

    public function hapus($id)
    {
        $this->peminjamModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/peminjam');
    }
}
