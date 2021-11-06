<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table                = 'peminjaman';
    protected $primaryKey           = 'kd_peminjaman';
    protected $allowedFields        = ['id_peminjam', 'tgl_permohonan', 'keperluan', 'surat_peminjaman'];

    public function getData()
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman.id_peminjam')->findAll();
    }
}
