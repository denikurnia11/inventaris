<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanRuanganModel extends Model
{
    protected $table                = 'peminjaman_ruangan';
    protected $primaryKey           = 'id_peminjaman_ruangan';
    protected $allowedFields        = ['tgl_pinjam', 'tgl_kembali', 'status', 'surat'];
}
