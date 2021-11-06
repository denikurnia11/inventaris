<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\DetailModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamModel;
use App\Models\RuanganModel;

class Detail extends BaseController
{
    protected $detailModel, $peminjamanModel, $peminjamModel, $barangModel, $ruanganModel;
    public function __construct()
    {
        $this->detailModel = new DetailModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->peminjamModel = new PeminjamModel();
        $this->barangModel = new BarangModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Detail Peminjaman',
            'detail' => $this->detailModel->findAll()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Detail Peminjaman',
            'peminjaman' => $this->peminjamanModel->findAll(), // Dropdown
            'peminjam' => $this->peminjamModel->findAll(), // Dropdown
            'barang' => $this->barangModel->findAll(), // Dropdown
            'ruangan' => $this->ruanganModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'kd_peminjaman' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kode Peminjaman harus diisi.'
                ]
            ],
            'id_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'id_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang harus diisi.'
                ]
            ],
            'id_ruangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama ruangan harus diisi.'
                ]
            ],
            'jml_pinjam' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah pinjam harus diisi.',
                    'integer' => 'Harus berupa angka.'
                ]
            ],
            'tgl_pinjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal pinjam harus diisi.'
                ]
            ],
            'tgl_kembali' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal kembali harus diisi.'
                ]
            ],
            'status_pinjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/detail/tambah')->withInput();
        }

        $this->detailModel->save([
            'kd_peminjaman' => $this->request->getVar('kd_peminjaman'),
            'id_peminjam' => $this->request->getVar('id_peminjam'),
            'id_barang' => $this->request->getVar('id_barang'),
            'id_ruangan' => $this->request->getVar('id_ruangan'),
            'jml_pinjam' => $this->request->getVar('jml_pinjam'),
            'tgl_pinjam' => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali' => $this->request->getVar('tgl_kembali'),
            'status_pinjam' => $this->request->getVar('status_pinjam'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/detail');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit Detail Peminjaman',
            'detail' => $this->detailModel->find($id),
            'peminjaman' => $this->peminjamanModel->findAll(), // Dropdown
            'peminjam' => $this->peminjamModel->findAll(), // Dropdown
            'barang' => $this->barangModel->findAll(), // Dropdown
            'ruangan' => $this->ruanganModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'kd_peminjaman' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kode Peminjaman harus diisi.'
                ]
            ],
            'id_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama peminjam harus diisi.'
                ]
            ],
            'id_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang harus diisi.'
                ]
            ],
            'id_ruangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama ruangan harus diisi.'
                ]
            ],
            'jml_pinjam' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah pinjam harus diisi.',
                    'integer' => 'Harus berupa angka.'
                ]
            ],
            'tgl_pinjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal pinjam harus diisi.'
                ]
            ],
            'tgl_kembali' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal kembali harus diisi.'
                ]
            ],
            'status_pinjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/detail/edit/' . $id)->withInput();
        }

        $this->detailModel->update($id, [
            'kd_peminjaman' => $this->request->getVar('kd_peminjaman'),
            'id_peminjam' => $this->request->getVar('id_peminjam'),
            'id_barang' => $this->request->getVar('id_barang'),
            'id_ruangan' => $this->request->getVar('id_ruangan'),
            'jml_pinjam' => $this->request->getVar('jml_pinjam'),
            'tgl_pinjam' => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali' => $this->request->getVar('tgl_kembali'),
            'status_pinjam' => $this->request->getVar('status_pinjam'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/detail');
    }

    public function hapus($id)
    {
        $this->detailModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/detail');
    }
}
