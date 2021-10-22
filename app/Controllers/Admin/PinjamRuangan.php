<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanRuanganModel;
use App\Models\PeminjamModel;
use App\Models\RuanganModel;

class PinjamRuangan extends BaseController
{
    protected $ruanganModel, $peminjamModel, $pinjamBrgModel;
    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
        $this->peminjamModel = new PeminjamModel();
        $this->pinjamRuangModel = new PeminjamanRuanganModel();
    }

    public function index()
    {
        $data = [
            'title'         => 'Data Peminjaman Ruangan',
            'pinjamRuangan' => $this->pinjamRuangModel->getData()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'     => 'Form Peminjaman Ruangan',
            'ruangan'   => $this->ruanganModel->findAll(),
            'peminjam'  => $this->peminjamModel->findAll(),
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
            'surat' => [
                'rules'  => 'ext_in[surat,pdf,docx]|max_size[surat,1024]',
                'errors' => [
                    'ext_in'   => 'File harus berextensi pdf atau word',
                    'max_size' => 'File maksimal 1mb.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/pinjamruangan/tambah')->withInput();
        }

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->pinjamRuangModel->save([
            'id_peminjam'   => $this->request->getVar('id_peminjam'),
            'id_ruangan'    => $this->request->getVar('id_ruangan'),
            'tgl_pinjam'    => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'   => $this->request->getVar('tgl_kembali'),
            'status'        => $this->request->getVar('status'),
            'surat'         => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/pinjamruangan');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Form Edit Peminjaman Ruangan',
            'pinjamRuangan' => $this->pinjamRuangModel->find($id),
            'ruangan'       => $this->ruanganModel->findAll(),
            'peminjam'      => $this->peminjamModel->findAll(),
            'validasi'      => \Config\Services::validation()
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
            'surat' => [
                'rules'  => 'ext_in[surat,pdf,docx]|max_size[surat,1024]',
                'errors' => [
                    'ext_in'   => 'File harus berextensi pdf atau word',
                    'max_size' => 'File maksimal 1mb.',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/pinjamruangan/edit' . $id)->withInput();
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

        $this->pinjamRuangModel->update($id, [
            'id_peminjam'   => $this->request->getVar('id_peminjam'),
            'id_barang'     => $this->request->getVar('id_barang'),
            'tgl_pinjam'    => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'   => $this->request->getVar('tgl_kembali'),
            'jml_brg'       => $this->request->getVar('jml_brg'),
            'status'        => $this->request->getVar('status'),
            'surat'         => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/pinjamruangan');
    }

    public function hapus($id)
    {
        // Nama surat
        $namaSurat = $this->pinjamRuangModel->find($id);
        // Hapus file surat
        unlink('files/barang/' . $namaSurat['surat']);
        // Hapus data
        $this->pinjamRuangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/pinjamruangan');
    }
}
