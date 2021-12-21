<?php

namespace App\Controllers\Admin;

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
    return view('peminjaman/daftar', [
      'title'  => 'Daftar Peminjaman',
      'peminjaman' => $this->peminjamanModel->getDataByStatus('dipinjam')
    ]);
  }

  public function request()
  {
    return view('peminjaman/request', [
      'title'  => 'Request Peminjaman',
      'peminjaman' => $this->peminjamanModel->getDataByStatus('pending')
    ]);
  }

  public function detail($id)
  {
    $peminjaman = $this->peminjamanModel->find($id);
    $peminjam = $this->peminjamModel->find($peminjaman['id_peminjam']);
    $inventaris = $this->detailModel->getData($id);

    return view('peminjaman/detail_peminjaman', [
      'title'  => 'Detail Peminjaman',
      'peminjaman' => $peminjaman,
      'peminjam' => $peminjam,
      'inventaris' => $inventaris
    ]);
  }

  public function laporan()
  {
    // Get tanggal awal
    $tglAwal = $this->request->getVar('tgl_awal');
    $tglAkhir = $this->request->getVar('tgl_akhir');
    $peminjaman = $this->peminjamanModel->getLaporan($tglAwal, $tglAkhir);
    $inventaris = $this->peminjamanModel
      ->select('peminjaman.id_peminjaman, inventaris.id_inventaris, inventaris.nama_inventaris')
      ->join('detail_peminjaman', 'peminjaman.id_peminjaman=detail_peminjaman.id_peminjaman')
      ->join('inventaris', 'detail_peminjaman.id_inventaris=inventaris.id_inventaris')
      ->findAll();

    $data = [
      'title'     => 'Laporan Peminjaman',
      'peminjaman' => $peminjaman,
      'inventaris' => $inventaris
    ];

    return view('peminjaman/laporan', $data);
  }

  public function cetak()
  {
    // Get tanggal awal
    $tglAwal = $this->request->getVar('tgl_awal');
    $tglAkhir = $this->request->getVar('tgl_akhir');
    $peminjaman = $this->peminjamanModel->getLaporan($tglAwal, $tglAkhir);
    $inventaris = $this->peminjamanModel
      ->select('peminjaman.id_peminjaman, inventaris.id_inventaris, inventaris.nama_inventaris')
      ->join('detail_peminjaman', 'peminjaman.id_peminjaman=detail_peminjaman.id_peminjaman')
      ->join('inventaris', 'detail_peminjaman.id_inventaris=inventaris.id_inventaris')
      ->findAll();

    $data = [
      'title'     => 'Cetak Laporan Peminjaman',
      'peminjaman' => $peminjaman,
      'inventaris' => $inventaris
    ];

    return view('peminjaman/cetak', $data);
  }
}
