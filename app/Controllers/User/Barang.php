<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel, $kategoriModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Barang',
            'barang' => $this->barangModel->getData()
        ];
        return json_encode($data);
    }
}
