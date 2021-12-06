<?php

namespace App\Controllers\User;

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
        return view('ruangan/index_user', $data);
    }

    public function pinjam($idRuangan)
    {
        $ruangan = $this->ruanganModel->find($idRuangan);

        if ($ruangan['status'] != 'tersedia') {
            return redirect()->to(base_url('user/ruangan'));
        }

        $data = [
            'title' => 'Form Peminjaman Ruangan',
            'ruangan' => $this->ruanganModel->find($idRuangan),
            'validasi' => \Config\Services::validation()
        ];
        return view('ruangan/pinjam', $data);
    }

    public function cetak($id)
    {
        $data = [
            'title'  => 'Status Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getDataByID($id),
        ];
        return view('ruangan/kartu', $data);
    }

    public function batal($id)
    {
        $peminjaman = $this->peminjamanRuangModel->find($id);

        if (!$peminjaman) return;

        $this->peminjamanRuangModel->changeStatus($id, 'batal');
        $this->peminjamModel->changeStatus($peminjaman['id_peminjam'], 'batal');

        session()->setFlashdata('pesan', 'Peminjaman berhasil dibatalkan.');
        return redirect()->to(base_url('user/status/ruangan'));
    }

    public function save($idRuangan)
    {
        //Validasi
        if (!$this->validate([
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
            return redirect()->to(base_url() . '/user/ruangan/pinjam/' . $idRuangan)->withInput();
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

        $this->peminjamanRuangModel->save([
            'id_peminjam'       => $idPeminjam,
            'id_ruangan'        => $idRuangan,
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => date("Y/m/d"),
            'tgl_selesai'       => null,
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => 'pending',
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/user/status/ruangan');
    }
}
