<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanBarangModel extends Model
{
  protected $table         = 'peminjaman_barang';
  protected $primaryKey    = 'id_peminjaman';
  protected $allowedFields = [
    'id_peminjam',
    'id_barang',
    'jml_barang',
    'tgl_pinjam',
    'tgl_kembali',
    'tgl_permohonan',
    'tgl_selesai',
    'keperluan',
    'status',
    'surat_peminjaman'
  ];

  public function getData()
  {
    return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')->findAll();
  }

  public function getLaporan($tglAwal = null, $tglAkhir = null)
  {
    return $this
      ->select('id_peminjaman, nama_peminjam, nama_barang, peminjaman_barang.jml_barang, tgl_permohonan, tgl_pinjam, tgl_kembali, tgl_selesai, peminjaman_barang.status')
      ->where('tgl_pinjam >=', $tglAwal ? $tglAwal : '0000-00-00')
      ->where('tgl_pinjam <=', $tglAkhir ? $tglAkhir : '2222-00-00')
      ->whereIn('peminjaman_barang.status', ['selesai', 'dipinjam', 'batal'])
      ->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')
      ->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')
      ->findAll();
  }

  public function getDataByStatus($status = 'pending')
  {
    return $this
      ->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')
      ->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')
      ->where('peminjaman_barang.status', $status)
      ->findAll();
  }

  public function getDataByStatusExcept($status = 'pending')
  {
    return $this
      ->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')
      ->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')
      ->where('peminjaman_barang.status !=', $status)
      ->findAll();
  }

  public function changeStatus($id, $status)
  {
    $this->set('status', $status)->where('id_peminjaman', $id)->update();
  }

  public function getDataByID($id)
  {
    return $this
      ->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')
      ->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')
      ->find($id);
  }

  public function getDataByUser($id)
  {
    return $this
      ->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')
      ->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')
      ->where('peminjam.id_user', $id)
      ->findAll();
  }
}
