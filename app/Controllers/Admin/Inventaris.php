<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventarisModel;
use App\Models\KategoriModel;

class Inventaris extends BaseController
{
    protected $inventarisModel, $kategoriModel, $peminjamanBarangModel, $peminjamModel;
    public function __construct()
    {
        $this->inventarisModel = new InventarisModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Inventaris',
            'inventaris' => $this->inventarisModel->getData()
        ];
        return view('inventaris/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Data',
            'kategori' => $this->kategoriModel->findAll(),
            'validasi' => \Config\Services::validation()
        ];
        return view('inventaris/tambah', $data);
    }

    public function save()
    {

        //Validasi
        if (!$this->validate([
            'id_inventaris' => [
                'rules'  => 'required|is_unique[inventaris.id_inventaris]',
                'errors' => [
                    'required'  => 'ID Inventaris harus diisi.',
                    'is_unique' => 'ID Inventaris sudah tersedia.'
                ]
            ],
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi.'
                ]
            ],
            'nama_inventaris' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang/ruangan harus diisi.'
                ]
            ],
            'tgl_perolehan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi.'
                ]
            ],
            'harga' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'integer'  => 'Harus berupa angka.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi.'
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,1024]',
                'errors' => [
                    'uploaded' => 'Foto harus diisi.',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'File harus berupa gambar',
                    'max_size' => 'Ukuran maksimal 1mb',
                ]
            ],
        ])) {
            // Redirect
            return redirect()->back()->withInput();
        }

        // Mengambil foto
        $fileFoto = $this->request->getFile('foto');
        // Membuat nama random untuk fotonya
        $namaFoto = $fileFoto->getRandomName();
        // Move ke folder public/files/inventaris
        $fileFoto->move('files/inventaris', $namaFoto);

        $this->inventarisModel->insert([
            'id_inventaris'     => $this->request->getVar('id_inventaris'),
            'id_kategori'       => $this->request->getVar('id_kategori'),
            'nama_inventaris'   => $this->request->getVar('nama_inventaris'),
            'tgl_perolehan'     => $this->request->getVar('tgl_perolehan'),
            'harga'             => $this->request->getVar('harga'),
            'foto'              => $namaFoto,
            'deskripsi'         => $this->request->getVar('deskripsi'),
            'status'            => 'tersedia',
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url('admin/inventaris'));
    }

    public function edit($id)
    {
        $inventaris = $this->inventarisModel->find($id);
        if ($inventaris == null) return redirect()->to(base_url('admin/inventaris'));
        $data = [
            'title'        => 'Form Edit Data',
            'inventaris'   => $inventaris,
            'kategori'     => $this->kategoriModel->findAll(),
            'validasi'     => \Config\Services::validation()
        ];
        return view('inventaris/edit', $data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'id_inventaris' => [
                'rules'  => 'required' . ($this->request->getVar('id_inventaris') === $id ? '' : '|is_unique[inventaris.id_inventaris,id_inventaris,$id]'),
                'errors' => [
                    'required'  => 'ID Inventaris harus diisi.',
                    'is_unique' => 'ID Inventaris sudah tersedia.'
                ]
            ],
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi.'
                ]
            ],
            'nama_inventaris' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang/ruangan harus diisi.'
                ]
            ],
            'tgl_perolehan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi.'
                ]
            ],
            'harga' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Harga harus diisi.',
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
            return redirect()->to(base_url('admin/inventaris/edit/' . $id))->withInput();
        }

        // Mengambil foto baru
        $fileFoto = $this->request->getFile('foto');
        // Mengambil nama foto lama dari input hidden
        $fotoLama = $this->request->getVar('fotoLama');
        // Cek apakah mengupload foto
        if ($fileFoto->getError() == 4) {
            $namaFoto = $fotoLama;
        } else {
            // Membuat nama random untuk fotonya
            $namaFoto = $fileFoto->getRandomName();
            // Move ke folder public/files/inventaris
            $fileFoto->move('files/inventaris', $namaFoto);
            // Hapus file lama
            unlink('files/inventaris/' . $fotoLama);
        }

        $this->inventarisModel->update($id, [
            'id_inventaris'     => $this->request->getVar('id_inventaris'),
            'id_kategori'       => $this->request->getVar('id_kategori'),
            'nama_inventaris'   => $this->request->getVar('nama_inventaris'),
            'tgl_perolehan'     => $this->request->getVar('tgl_perolehan'),
            'harga'             => $this->request->getVar('harga'),
            'foto'              => $namaFoto,
            'deskripsi'         => $this->request->getVar('deskripsi'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url('admin/inventaris'));
    }

    public function hapus($id)
    {
        // Nama foto
        $inventaris = $this->inventarisModel->find($id);
        // Hapus file foto
        unlink('files/inventaris/' . $inventaris['foto']);
        // Hapus data
        $this->inventarisModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/inventaris');
    }

    public function cetak()
    {
        $data = [
            'title' => 'Laporan Data Inventaris',
            'inventaris' => $this->inventarisModel->getData()
        ];
        return view('inventaris/cetak', $data);
    }
}
