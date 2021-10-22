<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\PeminjamanBrgModel;
use App\Models\PeminjamanRuanganModel;
use App\Models\PeminjamModel;

class Home extends BaseController
{

    public function index()
    {
        $barangModel = new BarangModel();
        $pinjamBrgModel = new PeminjamanBrgModel();
        $pinjamRuang = new PeminjamanRuanganModel();
        $user = new PeminjamModel();
        $data = [
            'barang' => $user->getData()
        ];
        dd($data);
        return view('welcome_message');
    }
}
