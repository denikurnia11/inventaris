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
            'nama_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'telp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjam/tambah')->withInput();
        }

        $this->peminjamModel->save([
            'id_user'       => $this->request->getVar('id_user'),
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'telp'          => $this->request->getVar('telp'),
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
            'nama_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'telp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjam/edit' . $id)->withInput();
        }

        $this->peminjamModel->update($id, [
            'id_user'       => $this->request->getVar('id_user'),
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'telp'          => $this->request->getVar('telp'),
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
