<?php

namespace App\Controllers\Admin\Peminjaman;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PeminjamanBarangModel;
use App\Models\PeminjamModel;

class Barang extends BaseController
{
  protected $peminjamModel, $peminjamanBarangModel, $barangModel;
  public function __construct()
  {
    $this->peminjamModel = new PeminjamModel();
    $this->barangModel = new BarangModel();
    $this->peminjamanBarangModel = new PeminjamanBarangModel();
  }

  public function cetak()
  {
    // Get tanggal awal
    $tglAwal = $this->request->getVar('tgl_awal');
    $tglAkhir = $this->request->getVar('tgl_akhir');
    $data = [
      'title'     => 'Cetak Laporan Peminjaman barang',
      'peminjaman' => $this->peminjamanBarangModel->getLaporan($tglAwal, $tglAkhir)
    ];
    return view('barang/laporan_cetak', $data);
  }

  public function changeStatus($id)
  {
    $data = $this->peminjamanBarangModel->find($id);
    $barang = $this->barangModel->find($data['id_barang']);
    $status = $this->request->getVar('status');
    switch ($status) {
      case 'setuju':
        if ($data['status'] != 'pending') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/barang/peminjaman/' . $id));
        }
        if ($barang['jml_barang'] < $data['jml_barang']) {
          session()->setFlashdata('pesan', 'Barang tidak mencukupi');
          return redirect()->to(base_url('admin/barang/peminjaman/' . $id));
        }
        // Mengurangi jml barang
        $this->barangModel->totalBarang($barang['id_barang'], $barang['jml_barang'] - $data['jml_barang']);
        // Mengganti status di tabel peminjaman
        $this->peminjamanBarangModel->changeStatus($id, 'dipinjam');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'disetujui');
        session()->setFlashdata('pesan', 'Peminjaman telah disetujui');
        return redirect()->to(base_url('admin/barang/peminjaman'));
      case 'tolak':
        if ($data['status'] != 'pending') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/barang/peminjaman/' . $id));
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanBarangModel->changeStatus($id, 'batal');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'ditolak');
        session()->setFlashdata('pesan', 'Peminjaman telah disetujui');
        return redirect()->to(base_url('admin/barang/peminjaman'));
      case 'kembali':
        if ($data['status'] != 'pending') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/barang/peminjaman/' . $id));
        }
        // Menambah jml barang
        $this->barangModel->totalBarang($barang['id_barang'], $barang['jml_barang'] + $data['jml_barang']);
        // Mengganti status di tabel peminjaman
        $this->peminjamanBarangModel->changeStatus($id, 'selesai');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'disetujui');
        session()->setFlashdata('pesan', 'Peminjaman telah disetujui');
        return redirect()->to(base_url('admin/barang/peminjaman'));
      default:
        session()->setFlashdata('pesan', 'Status gagal');
        return redirect()->to(base_url('admin/barang/request'));
    }
  }
}
