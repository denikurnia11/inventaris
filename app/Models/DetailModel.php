<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailModel extends Model
{
    protected $table                = 'detail_peminjaman';
    protected $primaryKey           = 'id_detail';
    protected $allowedFields        = ['id_peminjaman', 'id_inventaris'];

    public function getData()
    {
        return $this->join('peminjaman', 'peminjaman.id_peminjaman=detail_peminjaman.id_peminjaman')->join('inventaris', 'inventaris.id_inventaris=detail_peminjaman.id_inventaris')->findAll();
    }
    // public function getData()
    // {
    //     return $this->join('peminjaman', 'peminjaman.kd_peminjaman=detail_peminjaman.kd_peminjaman')->join('peminjam', 'peminjam.id_peminjam=detail_peminjaman.id_peminjam')->join('barang', 'barang.id_barang=detail_peminjaman.id_barang')->join('ruangan', 'ruangan.id_ruangan=detail_peminjaman.id_ruangan')->findAll();
    // }
}
