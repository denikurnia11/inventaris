<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanBrgModel extends Model
{
    protected $table                = 'peminjaman_brg';
    protected $primaryKey           = 'id_peminjaman_brg';
    protected $allowedFields        = ['tgl_pinjam', 'tgl_kembali', 'jml_brg', 'status', 'surat'];
}
