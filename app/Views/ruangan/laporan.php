<?php
function badge($status)
{
  switch ($status) {
    case 'selesai':
      return 'badge badge-success';
    case 'dipinjam':
      return 'badge badge-warning';
    default:
      return 'badge badge-danger';
  }
}
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/ruangan'); ?>">Ruangan</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <h5>Filter Data</h5>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="tgl_awal">Tanggal Awal</label>
              <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '' ?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="tgl_akhir">Tanggal Akhir</label>
              <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <button class="btn btn-success" onclick="cari()">Cari</button>
          <button class="btn btn-info ml-4" onclick="cetak()">Cetak</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (session()->getFlashData('pesan')) : ?>
  <div class="alert alert-success" role="alert"><?= session()->getFlashData('pesan') ?></div>
<?php endif; ?>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <td>No.</td>
              <td>ID Peminjaman</td>
              <td>Nama Peminjam</td>
              <td>Nama Ruangan</td>
              <td>Tanggal Permohonan</td>
              <td>Tanggal Pinjam</td>
              <td>Tanggal Kembali</td>
              <td>Tanggal Selesai</td>
              <td>Status</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($peminjaman as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_peminjaman'] ?></td>
                <td><?= $row['nama_peminjam'] ?></td>
                <td><?= $row['nama_ruangan'] ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_permohonan'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_pinjam'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_kembali'])) ?></td>
                <td><?= $row['tgl_selesai'] ? date('d F Y', strtotime($row['tgl_selesai'])) : '-' ?></td>
                <td class="text-center" style="text-transform: capitalize;">
                  <div class="<?= badge($row['status']) ?>">
                    <?= $row['status'] ?>
                  </div>
                </td>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  function cari() {
    document.location.replace(`<?= base_url('admin/ruangan/laporan') ?>?${query()}`)
  }

  function cetak() {
    document.location.replace(`<?= base_url('admin/peminjaman/ruangan/cetak') ?>?${query()}`)
  }

  function query() {
    return `tgl_awal=${$('#tgl_awal').val()}&tgl_akhir=${$('#tgl_akhir').val()}`
  }
</script>

<?= $this->endSection('content') ?>