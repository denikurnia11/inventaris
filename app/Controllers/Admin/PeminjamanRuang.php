<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanRuangModel;
use App\Models\PeminjamModel;
use App\Models\RuanganModel;

class PeminjamanRuang extends BaseController
{
    protected $peminjamModel, $peminjamanRuangModel;
    public function __construct()
    {
        $this->peminjamModel = new PeminjamModel();
        $this->ruanganModel = new RuanganModel();
        $this->peminjamanRuangModel = new PeminjamanRuangModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getData()
        ];
        return json_encode($data);
    }

    public function tambah()
    {
        $data = [
            'title'     => 'Form Peminjaman Barang',
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'ruangan'   => $this->ruanganModel->findAll(), // Dropdown
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
            'tgl_selesai' => [
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
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjamanruang/tambah')->withInput();
        }

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $this->peminjamanRuangModel->save([
            'id_peminjam'       => $this->request->getVar('id_peminjam'),
            'id_ruangan'        => $this->request->getVar('id_ruangan'),
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'tgl_selesai'       => $this->request->getVar('tgl_selesai'),
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => $this->request->getVar('status'),
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/peminjamanruang');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Form Edit Peminjaman ruang',
            'peminjaman' => $this->peminjamanRuangModel->find($id),
            'peminjam'  => $this->peminjamModel->findAll(), // Dropdown
            'ruangan'   => $this->ruanganModel->findAll(), // Dropdown
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
            'tgl_selesai' => [
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
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/peminjamanruang/edit' . $id)->withInput();
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

        $this->peminjamanRuangModel->update($id, [
            'id_peminjam'       => $this->request->getVar('id_peminjam'),
            'id_ruangan'        => $this->request->getVar('id_ruangan'),
            'tgl_pinjam'        => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali'       => $this->request->getVar('tgl_kembali'),
            'tgl_permohonan'    => $this->request->getVar('tgl_permohonan'),
            'tgl_selesai'       => $this->request->getVar('tgl_selesai'),
            'keperluan'         => $this->request->getVar('keperluan'),
            'status'            => $this->request->getVar('status'),
            'surat_peminjaman'  => $namaSurat
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/peminjamanruang');
    }

    public function hapus($id)
    {
        // Nama surat
        $namaSurat = $this->peminjamanRuangModel->find($id);
        // Hapus file surat
        unlink('files/surat/' . $namaSurat['surat']);
        // Hapus data
        $this->peminjamanRuangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/peminjamanruang');
    }
}
