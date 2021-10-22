<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    protected $ruanganModel;
    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Ruangan',
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'nama_ruangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama ruangan harus diisi.'
                ]
            ],
            'kapasitas' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Kapasitas harus diisi.',
                    'integer'  => 'Harus berupa angka.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/ruangan/tambah')->withInput();
        }

        $this->ruanganModel->save([
            'nama_ruangan' => $this->request->getVar('nama_ruangan'),
            'kapasitas'    => $this->request->getVar('kapasitas'),
            'deskripsi'    => $this->request->getVar('deskripsi'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/ruangan');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit Ruangan',
            'ruangan'  => $this->ruanganModel->find($id),
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'nama_ruangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama ruangan harus diisi.'
                ]
            ],
            'kapasitas' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Kapasitas harus diisi.',
                    'integer'  => 'Harus berupa angka.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/ruangan/edit/' . $id)->withInput();
        }

        $this->ruanganModel->update($id, [
            'nama_ruangan' => $this->request->getVar('nama_ruangan'),
            'kapasitas'    => $this->request->getVar('kapasitas'),
            'deskripsi'    => $this->request->getVar('deskripsi'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/ruangan');
    }

    public function hapus($id)
    {
        $this->ruanganModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/ruangan');
    }
}
