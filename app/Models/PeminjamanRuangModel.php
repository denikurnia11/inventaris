<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanRuangModel extends Model
{
    protected $table         = 'peminjaman_ruang';
    protected $primaryKey    = 'id_peminjaman';
    protected $allowedFields = [
        'id_peminjam',
        'id_ruangan',
        'jml_barang',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_permohonan',
        'tgl_selesai',
        'keperluan',
        'status',
        'surat_peminjaman'
    ];

    public function getData()
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruangan.id_ruangan')->findAll();
    }
}
