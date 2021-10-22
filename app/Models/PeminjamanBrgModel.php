<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanBrgModel extends Model
{
    protected $table                = 'peminjaman_brg';
    protected $primaryKey           = 'id_peminjaman_brg';
    protected $allowedFields        = ['id_peminjam', 'id_barang', 'tgl_pinjam', 'tgl_kembali', 'jml_brg', 'status', 'surat'];

    public function getData()
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_brg.id_peminjam')->join('barang', 'barang.id_barang=peminjaman_brg.id_barang')->findAll();
    }
}
