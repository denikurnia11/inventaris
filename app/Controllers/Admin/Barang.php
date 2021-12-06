<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PeminjamanBarangModel;
use App\Models\PeminjamModel;

class Barang extends BaseController
{
    protected $barangModel, $kategoriModel, $peminjamanBarangModel, $peminjamModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->kategoriModel = new KategoriModel();
        $this->peminjamanBarangModel = new PeminjamanBarangModel();
        $this->peminjamModel = new PeminjamModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Barang',
            'barang' => $this->barangModel->getData()
        ];
        return view('barang/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Form Tambah Barang',
            'kategori' => $this->kategoriModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        return view('barang/tambah', $data);
    }

    public function save()
    {
        // dd($this->request->getVar());
        //Validasi
        if (!$this->validate([
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori barang harus diisi.'
                ]
            ],
            'nama_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang harus diisi.'
                ]
            ],
            'jml_barang' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah barang harus diisi.',
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
        ])) {
            // Redirect
            return redirect()->back()->withInput();
        }

        // Mengambil foto
        $fileFoto = $this->request->getFile('foto');
        // Membuat nama random untuk fotonya
        $namaFoto = $fileFoto->getRandomName();
        // Move ke folder public/files/barang
        $fileFoto->move('files/barang', $namaFoto);

        $this->barangModel->save([
            'id_kategori'   => $this->request->getVar('id_kategori'),
            'nama_barang'   => $this->request->getVar('nama_barang'),
            'jml_barang'    => $this->request->getVar('jml_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'foto'          => $namaFoto,
            'tgl_perolehan' => $this->request->getVar('tgl_perolehan'),
            'harga'         => $this->request->getVar('harga'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/admin/barang');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Form Edit Barang',
            'barang'   => $this->barangModel->find($id),
            'kategori' => $this->kategoriModel->findAll(), // Dropdown
            'validasi' => \Config\Services::validation()
        ];
        return view('barang/edit', $data);
    }

    public function update($id)
    {
        //Validasi
        if (!$this->validate([
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori barang harus diisi.'
                ]
            ],
            'nama_barang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang harus diisi.'
                ]
            ],
            'jml_barang' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Jumlah barang harus diisi.',
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
                'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,1024]',
                'errors' => [
                    'uploaded' => 'Foto harus diisi.',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'File harus berupa gambar',
                    'max_size' => 'Ukuran maksimal 1mb',
                ]
            ],
            'tgl_perolehan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi.'
                ]
            ],
            'harga' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'integer'  => 'Harus berupa angka.'
                ]
            ],
        ])) {
            // Redirect
            return redirect()->to(base_url() . '/admin/barang/edit/' . $id)->withInput();
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
            // Move ke folder public/files/barang
            $fileFoto->move('files/barang', $namaFoto);
            // Hapus file lama
            unlink('files/barang/' . $fotoLama);
        }

        $this->barangModel->update($id, [
            'id_kategori'   => $this->request->getVar('id_kategori'),
            'nama_barang'   => $this->request->getVar('nama_barang'),
            'jml_barang'    => $this->request->getVar('jml_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'foto'          => $namaFoto,
            'tgl_perolehan' => $this->request->getVar('tgl_perolehan'),
            'harga'         => $this->request->getVar('harga'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to(base_url() . '/admin/barang');
    }

    public function hapus($id)
    {
        // Nama foto
        $namaFoto = $this->barangModel->find($id);
        // Hapus file foto
        unlink('files/barang/' . $namaFoto['foto']);
        // Hapus data
        $this->barangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/admin/barang');
    }

    public function request()
    {
        $data = [
            'title'     => 'Request Peminjaman Barang',
            'peminjaman' => $this->peminjamanBarangModel->getDataByStatus('pending')
        ];
        return view('barang/request', $data);
    }

    public function laporan()
    {
        // Get tanggal awal
        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');
        $data = [
            'title'     => 'Laporan Peminjaman Barang',
            'peminjaman' => $this->peminjamanBarangModel->getLaporan($tglAwal, $tglAkhir)
        ];

        return view('barang/laporan', $data);
    }

    public function peminjaman($id = null)
    {
        if ($id !== null) return $this->detailPeminjaman($id);
        $data = [
            'title'     => 'Daftar Peminjaman Barang',
            'peminjaman' => $this->peminjamanBarangModel->getDataByStatus('dipinjam')
        ];
        return view('barang/peminjaman', $data);
    }

    public function cetak()
    {
        $data = [
            'title' => 'Laporan Data Barang',
            'barang' => $this->barangModel->getData()
        ];
        return view('barang/cetak', $data);
    }

    private function detailPeminjaman($idPeminjaman)
    {
        $peminjaman = $this->peminjamanBarangModel->find($idPeminjaman);
        $barang = $this->barangModel->find($peminjaman['id_barang']);
        $peminjam = $this->peminjamModel->find($peminjaman['id_peminjam']);

        $data = [
            'title'     => 'Detail Peminjaman Barang',
            'peminjaman' => $peminjaman,
            'barang' => $barang,
            'peminjam' => $peminjam
        ];

        return view('barang/peminjaman_detail', $data);
    }
}
