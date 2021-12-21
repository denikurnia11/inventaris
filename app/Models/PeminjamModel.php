<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamModel extends Model
{
    protected $table                = 'peminjam';
    protected $primaryKey           = 'id_peminjam';
    protected $allowedFields        = ['id_user', 'nama_peminjam', 'nama_instansi', 'no_hp', 'status'];

    public function getData()
    {
        return $this->join('user', 'user.id_user=peminjam.id_user')->findAll();
    }

    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_peminjam', $id)->update();
    }
}
