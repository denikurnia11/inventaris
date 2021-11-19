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
        return json_encode($data);
    }

    public function pinjam($idBarang)
    {
        $data = [
            'title' => 'Form Peminjaman Barang',
            'barang' => $this->barangModel->find($idBarang),
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save($idBarang)
    {
        //Validasi
        if (!$this->validate([
            'id_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Barang harus diisi.'
                ]
            ],
            'jml_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jumlah barang harus diisi.'
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
            'tgl_permohonan' => [
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
                'rules'  => 'uploaded[surat]|ext_in[surat,pdf,docx]|max_size[surat,1024]',
                'errors' => [
                    'uploaded'   => 'File harus diisi.',
                    'ext_in'     => 'File harus berextensi pdf atau word',
                    'max_size'   => 'File maksimal 1mb.',
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
        $this->peminjamModel->save([
            'id_user'       => session()->idUser,
            'nama_peminjam' => $this->request->getVar('nama_peminjam'),
            'nama_instansi' => $this->request->getVar('nama_instansi'),
            'no_hp'         => $this->request->getVar('no_hp'),
            'status'        => 'pending',
        ]);
        // Get id_peminjam
        $peminjam = $this->peminjamModel->where('id_user', session()->idUser)->where('nama_peminjam', $this->request->getVar('nama_peminjam'))->where('nama_instansi', $this->request->getVar('nama_instansi'))->where('no_hp', $this->request->getVar('no_hp'))->first();

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat_peminjaman');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->peminjamanBarangModel->save([
            'id_peminjam'       => $peminjam['id_peminjam'],
            'id_barang'         => $this->request->getVar('id_barang'),
            'jml_barang'        => $this->request->getVar('jml_barang'),
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'tgl_selesai'       => '',
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => 'pending',
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/user/status');
    }
}
