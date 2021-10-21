<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table                = 'barang';
    protected $primaryKey           = 'id_barang';
    protected $allowedFields        = ['nama_barang', 'jml_brg', 'deskripsi', 'foto', 'tgl_perolehan', 'harga'];
}
