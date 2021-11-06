<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailModel extends Model
{
    protected $table                = 'detail_peminjaman';
    protected $primaryKey           = 'id_detail';
    protected $allowedFields        = ['kd_peminjaman', 'id_peminjam', 'id_barang', 'id_ruangan', 'jml_pinjam', 'tgl_pinjam', 'tgl_kembali', 'status_pinjam'];

    public function getData()
    {
        return $this->join('peminjaman', 'peminjaman.kd_peminjaman=detail_peminjaman.kd_peminjaman')->join('peminjam', 'peminjam.id_peminjam=detail_peminjaman.id_peminjam')->join('barang', 'barang.id_barang=detail_peminjaman.id_barang')->join('ruangan', 'ruangan.id_ruangan=detail_peminjaman.id_ruangan')->findAll();
    }
}