<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PeminjamanBarangModel;
use App\Models\PeminjamModel;

class Barang extends BaseController
{
    protected $barangModel, $peminjamanBarangModel, $peminjamModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->peminjamanBarangModel = new PeminjamanBarangModel();
        $this->peminjamModel = new PeminjamModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Barang',
            'barang' => $this->barangModel->getData()
        ];
        return view('barang/index_user', $data);
    }

    public function pinjam($idBarang)
    {
        $data = [
            'title' => 'Form Peminjaman Barang',
            'barang' => $this->barangModel->find($idBarang),
            'validasi' => \Config\Services::validation()
        ];
        return view('barang/pinjam', $data);
    }

    public function cetak($id)
    {
        $data = [
            'title'  => 'Status Peminjaman Barang',
            'peminjaman' => $this->peminjamanBarangModel->getDataByID($id),
        ];
        return view('barang/kartu', $data);
    }

    public function batal($id)
    {
        $peminjaman = $this->peminjamanBarangModel->find($id);

        if (!$peminjaman) return;

        $this->peminjamanBarangModel->changeStatus($id, 'batal');
        $this->peminjamModel->changeStatus($peminjaman['id_peminjam'], 'batal');

        session()->setFlashdata('pesan', 'Peminjaman berhasil dibatalkan.');
        return redirect()->to(base_url('user/status/barang'));
    }

    public function save($idBarang)
    {
        // Mencek jumlah barang
        $barang = $this->barangModel->find($idBarang);

        if ($barang['jml_barang'] <= 0) return redirect()->back();

        $jml_barang = $barang['jml_barang'] + 1;

        //Validasi
        if (!$this->validate([
            'jml_barang' => [
                'rules'  => "required|greater_than[0]|less_than[$jml_barang]",
                'errors' => [
                    'required' => 'Jumlah barang harus diisi.',
                    'greater_than' => 'Jumlah barang harus lebih dari 0',
                    'less_than' => 'Jumlah barang tidak mencukupi'
                ]
            ],
            'tgl_pinjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi.'
                ]
            ],
            'tgl_kembali' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi.'
                ]
            ],
            'keperluan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harga harus diisi.'
                ]
            ],
            'surat_peminjaman' => [
                'rules'  => 'uploaded[surat_peminjaman]|ext_in[surat_peminjaman,pdf,docx]|max_size[surat_peminjaman,1024]',
                'errors' => [
                    'uploaded'   => 'Surat harus diisi.',
                    'ext_in'     => 'Surat harus berextensi pdf atau word',
                    'max_size'   => 'Surat maksimal 1mb.',
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
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/user/barang/pinjam/' . $idBarang)->withInput();
        }

        $idPeminjam = $this->peminjamModel->insert([
            'id_user'       => session()->idUser,
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'nama_instansi' => $this->request->getVar('nama_instansi'),
            'no_hp'         => $this->request->getVar('no_hp'),
            'status'        => 'pending',
        ], true);

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat_peminjaman');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->peminjamanBarangModel->save([
            'id_peminjam'       => $idPeminjam,
            'id_barang'         => $idBarang,
            'jml_barang'        => $this->request->getVar('jml_barang'),
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => date("Y/m/d"),
            'tgl_selesai'       => null,
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => 'pending',
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/user/status/barang');
    }
}
