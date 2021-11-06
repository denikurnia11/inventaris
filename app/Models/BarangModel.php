<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table                = 'barang';
    protected $primaryKey           = 'id_barang';
    protected $allowedFields        = ['id_kategori', 'nama_barang', 'jml_barang', 'deskripsi', 'foto', 'tgl_perolehan', 'harga'];

    public function getData()
    {
        return $this->join('kategori', 'kategori.id_kategori=barang.id_kategori')->findAll();
    }
}
