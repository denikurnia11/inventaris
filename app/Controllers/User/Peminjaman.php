<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\DetailModel;
use App\Models\InventarisModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamModel;

class Peminjaman extends BaseController
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
    return view('peminjaman/index', [
      'title'  => 'Data Peminjaman',
      'inventaris' => $this->inventarisModel->join('kategori', 'kategori.id_kategori=inventaris.id_kategori')->where('status', 'tersedia')->findAll()
    ]);
  }

  public function pinjam()
  {
    return view('peminjaman/pinjam', [
      'title'    => 'Form Peminjaman',
      'validasi' => \Config\Services::validation()
    ]);
  }

  public function status($id = null)
  {
    if ($id) return $this->detail($id);
    return view('peminjaman/status', [
      'title'  => 'Status Peminjaman',
    ]);
  }

  private function detail($id)
  {
    $peminjaman = $this->peminjamanModel->find($id);
    $peminjam = $this->peminjamModel->find($peminjaman['id_peminjam']);
    $inventaris = $this->detailModel->getData($id);

    return view('peminjaman/detail', [
      'title'  => 'Detail Peminjaman',
      'peminjaman' => $peminjaman,
      'peminjam' => $peminjam,
      'inventaris' => $inventaris
    ]);
  }
}
