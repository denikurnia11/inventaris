<?php

namespace App\Controllers\API;

use App\Models\DetailModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamModel;
use CodeIgniter\RESTful\ResourceController;

class Peminjaman extends ResourceController
{
    protected $detailModel, $kategoriModel, $peminjamanModel, $peminjamModel;
    public function __construct()
    {
        $this->peminjamModel = new PeminjamModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailModel();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {

        // $data = [
        //     'nama_peminjam' => $this->request->getPost('nama_peminjam'),
        //     'nama_instansi' => $this->request->getPost('nama_instansi'),
        //     'no_hp' => $this->request->getPost('no_hp'),
        //     'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
        //     'tgl_kembali' => $this->request->getPost('tgl_kembali'),
        //     'keperluan' => $this->request->getPost('keperluan'),
        //     'surat_peminjaman' => $this->request->getPost('surat_peminjaman'),
        //     'inventaris' => $this->request->getPost('inventaris'),
        // ];
        $data = $this->request->getPost();
        // $data = json_decode(file_get_contents("php://input"));
        // $data = json_decode(json_encode($data), true);
        $idPeminjam = $this->peminjamModel->insert([
            'id_user'          => 1,
            'nama_peminjam'    => $data['nama_peminjam'],
            'nama_instansi'    => $data['nama_instansi'],
            'no_hp'            => $data['no_hp'],
            'status'           => 'pending'
        ], true);
        if (!$idPeminjam) {
            return $this->fail($this->peminjamModel->errors());
        }

        // Mengambil surat
        $fileSurat = $this->request->getFile('surat_peminjaman');
        // Membuat nama random untuk suratnya
        $namaSurat = $fileSurat->getRandomName();
        // Move ke folder public/files/surat
        $fileSurat->move('files/surat', $namaSurat);

        $idPeminjaman = $this->peminjamanModel->insert([
            'id_peminjam' => $idPeminjam,
            'tgl_pinjam' =>  $data['tgl_pinjam'],
            'tgl_kembali' => $data['tgl_kembali'],
            'tgl_permohonan' => date("Y/m/d"),
            'tgl_selesai' => null,
            'keperluan' => $data['keperluan'],
            'status' => 'pending',
            'surat_peminjaman' => $namaSurat
        ], true);
        if (!$idPeminjaman) {
            return $this->fail($this->peminjamanModel->errors());
        }

        $inventaris = array();
        for ($i = 0; $i < count($data['inventaris']); $i++) {
            $inventaris[$i] = [
                'id_peminjaman' => $idPeminjaman,
                'id_inventaris' => $data['inventaris'][$i]
            ];
        }
        $this->detailModel->insertBatch($inventaris);
        $response = [
            'status'   => 201,
            'messages' => 'Data Berhasil Ditambahkan'
        ];

        return $this->respond($response, 201);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
