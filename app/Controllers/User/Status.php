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

    public function index()
    {
        $data = [
            'title'  => 'Status Peminjaman',
            'barang' => $this->peminjamanBarangModel->getData(),
            'ruang' => $this->peminjamanRuangModel->getData(),
        ];
        return json_encode($data);
    }
}
