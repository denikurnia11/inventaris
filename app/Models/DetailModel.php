<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailModel extends Model
{
    protected $table                = 'detail_peminjaman';
    protected $primaryKey           = 'id_detail';
    protected $allowedFields        = ['id_peminjaman', 'id_inventaris'];

    public function getData($id)
    {
        return $this
            ->join('inventaris', 'inventaris.id_inventaris=detail_peminjaman.id_inventaris')
            ->join('kategori', 'inventaris.id_kategori=kategori.id_kategori')
            ->where('id_peminjaman', $id)
            ->findAll();
    }
}
