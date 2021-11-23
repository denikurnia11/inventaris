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

    public function getData($id = null)
    {
        if (!$id) {
            return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->findAll();
        } else {
            return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('')->findAll();
        }
    }

    public function getLaporan($tglAwal = null, $tglAkhir = null)
    {
        return $this->where('tgl_permohonan =>', $tglAwal)->where('tgl_permohonan <=', $tglAkhir)->where('status !=', 'pending')->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->findAll();
    }

    public function getDataByStatus($status = 'pending')
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('peminjam.status', $status)->findAll();
    }

    public function getDataByStatusExcept($status = 'pending')
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('peminjam.status !=', $status)->findAll();
    }


    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_peminjaman', $id)->update();
    }
}
