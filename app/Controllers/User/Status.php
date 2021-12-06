<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PeminjamanBarangModel;
use App\Models\PeminjamanRuangModel;

class Status extends BaseController
{
    protected  $peminjamanBarangModel, $peminjamanRuangModel;
    public function __construct()
    {
        $this->peminjamanBarangModel = new PeminjamanBarangModel();
        $this->peminjamanRuangModel = new PeminjamanRuangModel();
    }

    public function ruangan()
    {
        $data = [
            'title'  => 'Status Peminjaman Ruangan',
            'peminjaman' => $this->peminjamanRuangModel->getDataByUser(session()->idUser),
        ];
        return view('ruangan/status', $data);
    }

    public function barang()
    {
        $data = [
            'title'  => 'Status Peminjaman Barang',
            'peminjaman' => $this->peminjamanBarangModel->getDataByUser(session()->idUser),
        ];
        return view('barang/status', $data);
    }
}
