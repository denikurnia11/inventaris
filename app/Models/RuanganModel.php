<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table                = 'ruangan';
    protected $primaryKey           = 'id_ruangan';
    protected $allowedFields        = ['nama_ruangan', 'kapasitas', 'status', 'deskripsi'];


    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_ruangan', $id)->update();
    }
}
