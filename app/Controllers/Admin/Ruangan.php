<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanRuangModel;
use App\Models\PeminjamModel;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    protected $ruanganModel, $peminjamanRuangModel, $peminjamModel;
    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
        $this->peminjamanRuangModel = new PeminjamanRuangModel();
        $this->peminjamModel = new PeminjamModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];
        return view('ruangan/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Ruangan',
            'validasi' => \Config\Services::validation()
        ];
        return view('ruangan/tambah', $data);
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
            'status'       => 'tersedia',
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
        return view('ruangan/edit', $data);
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
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
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
            'status'       => $this->request->getVar('status'),
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

    public function peminjaman($id = null)
    {
        if ($id !== null) return $this->detailPeminjaman($id);
        $data = [
            'title'     => 'Daftar Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getDataByStatus('dipinjam')
        ];
        return view('ruangan/peminjaman', $data);
    }

    private function detailPeminjaman($idPeminjaman)
    {
        $peminjaman = $this->peminjamanRuangModel->find($idPeminjaman);
        $ruangan = $this->ruanganModel->find($peminjaman['id_ruangan']);
        $peminjam = $this->peminjamModel->find($peminjaman['id_peminjam']);

        $data = [
            'title'     => 'Detail Peminjaman Ruangan',
            'peminjaman' => $peminjaman,
            'ruangan' => $ruangan,
            'peminjam' => $peminjam
        ];

        return view('ruangan/peminjaman_detail', $data);
    }

    public function request()
    {
        $data = [
            'title'     => 'Request Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getDataByStatus('pending')
        ];
        return view('ruangan/request', $data);
    }

    public function laporan()
    {
        // Get tanggal awal
        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');
        $data = [
            'title'     => 'Laporan Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getLaporan($tglAwal, $tglAkhir)
        ];

        return view('ruangan/laporan', $data);
    }

    public function cetak()
    {
        $data = [
            'title' => 'Laporan Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];
        return view('ruangan/cetak', $data);
    }
}
