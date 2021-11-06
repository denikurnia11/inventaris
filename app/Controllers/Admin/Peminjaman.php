<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\PeminjamModel;

class Peminjaman extends BaseController
{
    protected $peminjamModel, $peminjamanModel;
    public function __construct()
    {
        $this->peminjamModel = new PeminjamModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Peminjaman',
            'peminjaman' => $this->peminjamanModel->getData()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'     => 'Form Peminjaman Barang',
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'validasi'  => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save()
    {
        //Validasi
        if (!$this->validate([
            'id_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Peminjam harus diisi.'
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
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjaman/tambah')->withInput();
        }

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->pinjamBrgModel->save([
            'id_peminjam'       => $this->request->getVar('id_peminjam'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'keperluan'         => $this->request->getVar('keperluan'),
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/peminjaman');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Form Edit Peminjaman Barang',
            'peminjaman' => $this->peminjamanModel->find($id),
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'validasi'  => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'id_peminjam' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Peminjam harus diisi.'
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
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjaman/edit' . $id)->withInput();
        }

        // Mengambil surat baru
        $fileSurat = $this->request->getFile('surat');
        // Mengambil nama surat lama dari input hidden
        $suratLama = $this->request->getVar('suratLama');
        // Cek apakah mengupload surat
        if ($fileSurat->getError() == 4) {
            $namaSurat = $suratLama;
        } else {
            // Membuat nama random untuk suratnya
            $namaSurat = $fileSurat->getRandomName();
            // Move ke folder public/files/surat
            $fileSurat->move('files/surat', $namaSurat);
            // Hapus file lama
            unlink('files/surat/' . $suratLama);
        }

        $this->pinjamBrgModel->update($id, [
            'id_peminjam'       => $this->request->getVar('id_peminjam'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'keperluan'         => $this->request->getVar('keperluan'),
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/peminjaman');
    }

    public function hapus($id)
    {
        // Nama surat
        $namaSurat = $this->pinjamBrgModel->find($id);
        // Hapus file surat
        unlink('files/barang/' . $namaSurat['surat']);
        // Hapus data
        $this->pinjamBrgModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/peminjaman');
    }
}
