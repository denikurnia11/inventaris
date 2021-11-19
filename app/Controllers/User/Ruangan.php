<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PeminjamanRuangModel;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    protected $ruanganModel, $peminjamanRuangModel;
    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
        $this->peminjamanRuangModel = new PeminjamanRuangModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];
        return json_encode($data);
    }

    public function pinjam($idRuangan)
    {
        $data = [
            'title' => 'Form Peminjaman Ruangan',
            'ruangan' => $this->ruanganModel->find($idRuangan),
            'validasi' => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save($idRuangan)
    {
        //Validasi
        if (!$this->validate([
            'id_ruangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Ruangan harus diisi.'
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
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
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
            return redirect()->to(base_url() . '/user/ruangan/pinjam/' . $idRuangan)->withInput();
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

        $this->peminjamanRuangModel->save([
            'id_peminjam'       => $peminjam['id_peminjam'],
            'id_ruangan'        => $this->request->getVar('id_ruangan'),
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'tgl_selesai'       => '',
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => $this->request->getVar('status'),
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/user/status');
    }
}
