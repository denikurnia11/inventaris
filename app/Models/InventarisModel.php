<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $table                = 'inventaris';
    protected $primaryKey           = 'id_inventaris';
    protected $allowedFields        = ['id_kategori', 'nama_inventaris',  'deskripsi', 'foto', 'tgl_perolehan', 'harga', 'status'];

    public function getData()
    {
        return $this->join('kategori', 'kategori.id_kategori=inventaris.id_kategori')->findAll();
    }

    // public function totalBarang($id, $jml)
    // {
    //     $this->set('jml_barang', $jml)->where('id_barang', $id)->update();
    // }
}
