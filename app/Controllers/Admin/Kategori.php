<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('kategori/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Kategori',
            'validasi' => \Config\Services::validation()
        ];
        return view('kategori/tambah', $data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'nama_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama kategori harus diisi.'
                ]
            ]
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/kategori/tambah')->withInput();
        }

        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/kategori');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit Kategori',
            'kategori' => $this->kategoriModel->find($id),
            'validasi' => \Config\Services::validation()
        ];
        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'nama_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama kategori harus diisi.'
                ]
            ]
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/kategori/edit/' . $id)->withInput();
        }

        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/kategori');
    }

    public function hapus($id)
    {
        $this->kategoriModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/kategori');
    }
}
