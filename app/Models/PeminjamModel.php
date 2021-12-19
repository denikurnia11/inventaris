<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamModel extends Model
{
    protected $table                = 'peminjam';
    protected $primaryKey           = 'id_peminjam';
    protected $allowedFields        = ['id_user', 'nama_peminjam', 'nama_instansi', 'no_hp', 'status'];
    protected $validationRules = [
        'id_user'          => 'required',
        'nama_peminjam'    => 'required',
        'nama_instansi'    => 'required',
        'no_hp'            => 'required',
        'status'           => 'required'
    ];
    protected $validationMessages = [
        'id_user'          => [
            'required' => 'Id User harus diisi'
        ],
        'nama_peminjam'    => [
            'required' => 'Nama harus diisi'
        ],
        'nama_instansi'    => [
            'required' => 'Instansi harus diisi'
        ],
        'no_hp'            => [
            'required' => 'Nomor HP harus diisi'
        ],
        'status'           => [
            'required' => 'Status harus diisi'
        ],
    ];

    public function getData()
    {
        return $this->join('user', 'user.id_user=peminjam.id_user')->findAll();
    }

    public function changeStatus($id, $status)
    {
        $this->set('status', $status)->where('id_peminjam', $id)->update();
    }
}
