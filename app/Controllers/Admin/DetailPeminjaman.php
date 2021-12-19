<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DetailModel;
use App\Models\InventarisModel;
use App\Models\PeminjamanModel;

class DetailPeminjaman extends BaseController
{
    protected $detailModel, $peminjamanModel, $inventarisModel;
    public function __construct()
    {
        $this->detailModel = new DetailModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->inventarisModel = new InventarisModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Detail Peminjaman',
            'detail' => $this->detailModel->getData()
        ];
        // return view('detail/index', $data);
        // dd($data);
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Form Tambah Data',
            'peminjaman' => $this->peminjamanModel->findAll(), // Dropdown
            'inventaris' => $this->inventarisModel->findAll(), // Dropdown
            'validasi'   => \Config\Services::validation()
        ];
        // dd($data);
        // return view('detail/tambah', $data);
        return json_encode($data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'id_peminjaman' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kolom harus diisi.'
                ]
            ],
            'id_inventaris' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kolom harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/detailpeminjaman/tambah')->withInput();
        }

        $this->detailModel->save([
            'id_peminjaman' => $this->request->getVar('id_peminjaman'),
            'id_inventaris' => $this->request->getVar('id_inventaris'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/detailpeminjaman');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit Data',
            'detail'  => $this->detailModel->find($id),
            'peminjaman' => $this->peminjamanModel->findAll(), // Dropdown
            'inventaris' => $this->inventarisModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        // return view('detail/edit', $data);
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'id_peminjaman' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kolom harus diisi.'
                ]
            ],
            'id_inventaris' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kolom harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/detailpeminjaman/edit/' . $id)->withInput();
        }

        $this->detailModel->update($id, [
            'id_peminjaman' => $this->request->getVar('id_peminjaman'),
            'id_inventaris' => $this->request->getVar('id_inventaris'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/detailpeminjaman');
    }

    public function hapus($id)
    {
        $this->detailModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/detailpeminjaman');
    }
}
