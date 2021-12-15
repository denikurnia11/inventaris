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
            return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('id_peminjaman', $id)->first();
        }
    }

    public function getLaporan($tglAwal = '0000-00-00', $tglAkhir = '2222-00-00')
    {
        return $this
            ->select('id_peminjaman, nama_peminjam, nama_ruangan, tgl_permohonan, tgl_pinjam, tgl_kembali, tgl_selesai, peminjaman_ruang.status')
            ->where('tgl_pinjam >=', $tglAwal ? $tglAwal : '0000-00-00')
            ->where('tgl_pinjam <=', $tglAkhir ? $tglAkhir : '2222-00-00')
            ->whereIn('peminjaman_ruang.status', ['selesai', 'dipinjam', 'batal'])
            ->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')
            ->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')
            ->findAll();
    }

    public function getDataByStatus($status = 'pending')
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('peminjaman_ruang.status', $status)->findAll();
    }

    public function getDataByStatusExcept($status = 'pending')
    {
        return $this->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')->where('peminjaman_ruang.status !=', $status)->findAll();
    }

    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_peminjaman', $id)->update();
    }

    public function getDataByID($id)
    {
        return $this
            ->select('id_peminjaman, nama_peminjam, nama_instansi, nama_ruangan, no_hp, tgl_pinjam, tgl_kembali, peminjam.status, keperluan')
            ->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')
            ->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')
            ->find($id);
    }

    public function getDataByUser($id)
    {
        return $this
            ->select('id_peminjaman, nama_peminjam, nama_instansi, nama_ruangan, tgl_pinjam, peminjam.status, keperluan')
            ->join('ruangan', 'ruangan.id_ruangan=peminjaman_ruang.id_ruangan')
            ->join('peminjam', 'peminjam.id_peminjam=peminjaman_ruang.id_peminjam')
            ->where('peminjam.id_user', $id)
            ->findAll();
    }
}
