<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamModel extends Model
{
    protected $table                = 'peminjam';
    protected $primaryKey           = 'id_peminjam';
    protected $allowedFields        = ['nama_peminjam', 'telp'];
}
