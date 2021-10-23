<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PeminjamanBrgModel;
use App\Models\PeminjamModel;

class PinjamBarang extends BaseController
{
    protected $barangModel, $peminjamModel, $pinjamBrgModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->peminjamModel = new PeminjamModel();
        $this->pinjamBrgModel = new PeminjamanBrgModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Peminjaman Barang',
            'pinjamBrg' => $this->pinjamBrgModel->getData()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'     => 'Form Peminjaman Barang',
            'barang'    => $this->barangModel->findAll(), // Dropdown
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'validasi'  => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function save()
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
            'jml_brg' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'integer' => 'Harus berupa angka.'
                ]
            ],
            'surat' => [
                'rules'  => 'uploaded[surat]|ext_in[surat,pdf,docx]|max_size[surat,1024]',
                'errors' => [
                    'uploaded'   => 'File harus diisi.',
                    'ext_in'     => 'File harus berextensi pdf atau word',
                    'max_size'   => 'File maksimal 1mb.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/pinjambarang/tambah')->withInput();
        }

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->pinjamBrgModel->save([
            'id_peminjam'   => $this->request->getVar('id_peminjam'),
            'id_barang'     => $this->request->getVar('id_barang'),
            'tgl_pinjam'    => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'   => $this->request->getVar('tgl_kembali'),
            'jml_brg'       => $this->request->getVar('jml_brg'),
            'status'        => $this->request->getVar('status'),
            'surat'         => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/pinjambarang');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Form Edit Peminjaman Barang',
            'pinjamBrg' => $this->pinjamBrgModel->find($id),
            'barang'    => $this->barangModel->findAll(), // Dropdown
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'validasi'  => \Config\Services::validation()
        ];
        return json_encode($data);
    }

    public function update($id)
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
            'jml_brg' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'integer' => 'Harus berupa angka.'
                ]
            ],
            'surat' => [
                'rules'  => 'ext_in[surat,pdf,docx]|max_size[surat,1024]',
                'errors' => [
                    'ext_in' => 'File harus berextensi pdf atau word',
                    'max_size' => 'File maksimal 1mb.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/pinjambarang/edit' . $id)->withInput();
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
            'id_peminjam'   => $this->request->getVar('id_peminjam'),
            'id_barang'     => $this->request->getVar('id_barang'),
            'tgl_pinjam'    => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'   => $this->request->getVar('tgl_kembali'),
            'jml_brg'       => $this->request->getVar('jml_brg'),
            'status'        => $this->request->getVar('status'),
            'surat'         => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/pinjambarang');
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
        return redirect()->to(base_url() . '/admin/pinjambarang');
    }
}
