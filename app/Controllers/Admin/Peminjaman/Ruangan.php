<?php

namespace App\Controllers\Admin\Peminjaman;

use App\Controllers\BaseController;
use App\Models\PeminjamanRuangModel;
use App\Models\PeminjamModel;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
  protected $peminjamModel, $peminjamanRuangModel;
  public function __construct()
  {
    $this->peminjamModel = new PeminjamModel();
    $this->ruanganModel = new RuanganModel();
    $this->peminjamanRuangModel = new PeminjamanRuangModel();
  }

  public function cetak()
  {
    // Get tanggal awal
    $tglAwal = $this->request->getVar('tgl_awal');
    $tglAkhir = $this->request->getVar('tgl_akhir');
    $data = [
      'title'     => 'Cetak Laporan Peminjaman Ruangan',
      'peminjaman' => $this->peminjamanRuangModel->getLaporan($tglAwal, $tglAkhir)
    ];

    return view('ruangan/laporan_cetak', $data);
  }

  public function changeStatus($id)
  {
    $data = $this->peminjamanRuangModel->find($id);
    $ruangan = $this->ruanganModel->find($data['id_ruangan']);
    $status = $this->request->getVar('status');
    switch ($status) {
      case 'setuju':
        if ($data['status'] != 'pending') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/ruangan/peminjaman/' . $id));
        }
        if ($ruangan['status'] == 'tidak tersedia') {
          session()->setFlashdata('pesan', 'Ruangan sudah terpinjam');
          return redirect()->to(base_url('admin/ruangan/peminjaman/' . $id));
        };
        // Mengganti status ruangan
        $this->ruanganModel->changeStatus($data['id_ruangan'], 'tidak tersedia');
        // Mengganti status di tabel peminjaman
        $this->peminjamanRuangModel->changeStatus($id, 'dipinjam');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'disetujui');

        session()->setFlashdata('pesan', 'Peminjaman telah disetujui');
        return redirect()->to(base_url('admin/ruangan/peminjaman'));
      case 'tolak':
        if ($data['status'] != 'pending') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/ruangan/peminjaman/' . $id));
        }
        // Mengganti status di tabel peminjaman
        $this->peminjamanRuangModel->changeStatus($id, 'batal');
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'ditolak');

        session()->setFlashdata('pesan', 'Peminjaman telah ditolak');
        return redirect()->to(base_url('admin/ruangan/request'));
      case 'kembali':
        if ($data['status'] != 'dipinjam') {
          session()->setFlashdata('pesan', 'Status gagal');
          return redirect()->to(base_url('admin/ruangan/peminjaman/'));
        }
        // Mengganti status ruangan
        $this->ruanganModel->changeStatus($data['id_ruangan'], 'tersedia');
        // Mengganti status di tabel peminjaman
        $this->peminjamanRuangModel->changeStatus($id, 'selesai');
        $this->peminjamanRuangModel->set('tgl_selesai', date("Y/m/d"))->where('id_peminjaman', $id)->update();
        // Menggati status di tabel peminjam
        $this->peminjamModel->changeStatus($data['id_peminjam'], 'disetujui');

        session()->setFlashdata('pesan', 'Peminjaman telah dikembalikan');
        return redirect()->to(base_url('admin/ruangan/peminjaman'));
      default:
        session()->setFlashdata('pesan', 'Status gagal');
        return redirect()->to(base_url('admin/ruangan/request'));
    }
  }
}
