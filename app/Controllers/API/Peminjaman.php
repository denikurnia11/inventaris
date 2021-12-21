<?php

namespace App\Controllers\API;

use App\Models\DetailModel;
use App\Models\InventarisModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamModel;
use CodeIgniter\RESTful\ResourceController;

class Peminjaman extends ResourceController
{
    protected $detailModel, $kategoriModel, $peminjamanModel, $peminjamModel, $inventarisModel;
    public function __construct()
    {
        $this->peminjamModel = new PeminjamModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailModel();
        $this->inventarisModel = new InventarisModel();
    }

    public function index()
    {
        // Check if request logged in
        if (session()->idUser === null) return $this->failForbidden('Tidak punya akses');

        // If the user is 'admin' then respond all the record, else if the user is 'user' then respond record in the current user
        if (session()->role === 'admin') {
            // If 'status' query not exist then return all record
            $tglAwal = $this->request->getVar('tgl_awal');
            $tglAkhir = $this->request->getVar('tgl_akhir');
            $peminjaman = $this->peminjamanModel->getLaporan($tglAwal, $tglAkhir);
            $inventaris = $this->detailModel->getData();

            return $this->respond([
                'peminjaman' => $peminjaman,
                'inventaris' => $inventaris
            ]);
        } else if (session()->role === 'user') {
            $peminjaman = $this->peminjamanModel->getDataByUser(session()->idUser);
            return $this->respond($peminjaman);
        }
    }

    public function show($id = null)
    {
        // $peminjaman = $this->peminjamanModel->find($id);
        // $peminjam = $this->peminjamModel->find($peminjaman)
        return $this->fail('awdwa');
    }

    public function create()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
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
                    'required' => 'Keperluan harus diisi.'
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
        ]);
        $validation->withRequest($this->request)->run();

        if ($validation->getErrors()) {
            return $this->respond([
                'status'   => 'fail',
                'errors' => $validation->getErrors()
            ], 400);
        }

        $data = $this->request->getPost();

        $idPeminjam = $this->peminjamModel->insert([
            'id_user'          => $data['id_user'],
            'nama_peminjam'    => $data['nama_peminjam'],
            'nama_instansi'    => $data['nama_instansi'],
            'no_hp'            => $data['no_hp'],
            'status'           => 'pending'
        ], true);

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat_peminjaman');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $idPeminjaman = $this->peminjamanModel->insert([
            'id_peminjam' => $idPeminjam,
            'tgl_pinjam' =>  $data['tgl_pinjam'],
            'tgl_kembali' => $data['tgl_kembali'],
            'tgl_permohonan' => date("Y/m/d"),
            'tgl_selesai' => null,
            'keperluan' => $data['keperluan'],
            'status' => 'pending',
            'surat_peminjaman' => $namaSurat
        ], true);

        $arr = json_decode($data['inventaris'], true);
        $inventaris = array();
        for ($i = 0; $i < count($arr); $i++) {
            $_inv = $this->inventarisModel->find($arr[$i]);
            if (!$_inv || $_inv['status'] == 'tidak tersedia') {
                return $this->respond([
                    'status'   => 'error',
                    'message' => 'barang/ruang tidak tersedia'
                ], 400);
            }
            $inventaris[$i] = [
                'id_peminjaman' => $idPeminjaman,
                'id_inventaris' => $arr[$i]
            ];
        }

        $this->detailModel->insertBatch($inventaris);
        $response = [
            'status'   => 201,
            'messages' => 'Data Berhasil Ditambahkan'
        ];
        session()->setFlashdata('pesan', 'Peminjaman berhasil diajukan');
        return $this->respond($response, 201);
    }

    public function batal($id = null)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) return $this->failNotFound();

        if ($peminjaman['status'] != 'pending') {
            return $this->fail('peminjaman tidak dapat dibatalkan');
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanModel->changeStatus($id, 'batal');
        $this->peminjamanModel->set('tgl_selesai', date("Y/m/d"))->where('id_peminjaman', $id)->update();
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($peminjaman['id_peminjam'], 'batal');
        session()->setFlashdata('pesan', 'Peminjaman telah dibatalkan');
        return $this->respond([
            'message' => 'Peminjaman telah dibatalkan'
        ]);
    }

    public function tolak($id = null)
    {
        if (session()->role !== 'admin') return $this->failForbidden();

        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) return $this->failNotFound();

        if ($peminjaman['status'] != 'pending') {
            return $this->fail('peminjaman tidak dapat ditolak');
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanModel->changeStatus($id, 'batal');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($peminjaman['id_peminjam'], 'ditolak');
        session()->setFlashdata('pesan', 'Peminjaman telah ditolak');
        return $this->respond([
            'message' => 'peminjaman telah ditolak'
        ]);
    }

    public function setuju($id = null)
    {
        if (session()->role !== 'admin') return $this->failForbidden();

        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) return $this->failNotFound();

        if ($peminjaman['status'] != 'pending') {
            return $this->fail('peminjaman tidak dapat disetujui');
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanModel->changeStatus($id, 'dipinjam');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($peminjaman['id_peminjam'], 'disetujui');

        $detail = $this->detailModel->where('id_peminjaman', $id)->findAll();

        for ($i = 0; $i < count($detail); $i++) {
            $inventaris = $this->inventarisModel->find($detail[$i]['id_inventaris']);
            if ($inventaris['status'] == 'tidak tersedia') {
                return $this->fail('barang/ruang tidak tersedia');
            }
            $this->inventarisModel->changeStatus($inventaris['id_inventaris'], 'tidak tersedia');
        }

        session()->setFlashdata('pesan', 'Peminjaman telah disetujui');
        return $this->respond([
            'message' => 'peminjaman telah disetujui'
        ]);
    }

    public function kembali($id = null)
    {
        if (session()->role !== 'admin') return $this->failForbidden();

        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) return $this->failNotFound();

        if ($peminjaman['status'] != 'dipinjam') {
            return $this->fail('peminjaman tidak dapat dikembalikan');
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanModel->changeStatus($id, 'selesai');
        $this->peminjamanModel->set('tgl_selesai', date("Y/m/d"))->where('id_peminjaman', $id)->update();

        $detail = $this->detailModel->where('id_peminjaman', $id)->findAll();

        for ($i = 0; $i < count($detail); $i++) {
            $this->inventarisModel->changeStatus($detail[$i]['id_inventaris'], 'tersedia');
        }

        session()->setFlashdata('pesan', 'Peminjaman telah dikembalikan');
        return $this->respond([
            'message' => 'peminjaman telah dikembalikan'
        ]);
    }
}
