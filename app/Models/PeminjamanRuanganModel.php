<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanRuanganModel extends Model
{
    protected $table                = 'peminjaman_ruangan';
    protected $primaryKey           = 'id_peminjaman_ruangan';
    protected $allowedFields        = ['id_peminjam', 'id_ruangan', 'tgl_pinjam', 'tgl_kembali', 'status', 'surat'];

    public function getData()
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruangan.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruangan.id_ruangan')->findAll();
    }
}
