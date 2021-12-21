<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $table                = 'inventaris';
    protected $primaryKey           = 'id_inventaris';
    protected $allowedFields        = ['id_inventaris', 'id_kategori', 'nama_inventaris',  'deskripsi', 'foto', 'tgl_perolehan', 'harga', 'status'];

    public function getData()
    {
        return $this->join('kategori', 'kategori.id_kategori=inventaris.id_kategori')->findAll();
    }

    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_inventaris', $id)->update();
    }
}
