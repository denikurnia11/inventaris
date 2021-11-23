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
    return $this->where('tgl_permohonan =>', $tglAwal)->where('tgl_permohonan <=', $tglAkhir)->where('status !=', 'pending')->join('peminjam', 'peminjam.id_peminjam=peminjaman_barang.id_peminjam')->join('barang', 'barang.id_barang=peminjaman_barang.id_barang')->findAll();
  }

  public function changeStatus($id, $status)
  {
    $this->set('status', $status)->where('id_peminjaman', $id)->update();
  }
}
