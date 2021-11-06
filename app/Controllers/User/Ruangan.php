<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    protected $ruanganModel;
    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];
        return json_encode($data);
    }
}
