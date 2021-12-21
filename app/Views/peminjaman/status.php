<?php
function badge($status)
{
  switch ($status) {
    case 'disetujui':
      return 'badge badge-success';
    case 'pending':
      return 'badge badge-warning';
    default:
      return 'badge badge-danger';
  }
}
?>

<?= $this->extend('template_user') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('user/peminjaman'); ?>">Peminjaman</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dtb">
          <thead>
            <tr>
              <td>ID Peminjaman</td>
              <td>Nama Peminjam</td>
              <td>Nama Instansi</td>
              <td>Tanggal Pinjam</td>
              <td>Tanggal Kembali</td>
              <td>Tanggal Permohonan</td>
              <td>Status</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  const switchStatus = (status) => {
    switch (status) {
      case 'disetujui':
        return '<div class="badge badge-success">Disetujui</div>'
      case 'pending':
        return '<div class="badge badge-warning">Pending</div>'
      case 'batal':
        return '<div class="badge badge-danger">Batal</div>'
      case 'ditolak':
        return '<div class="badge badge-danger">Ditolak</div>'
    }
  }

  const arrToEle = (arr) => {
    return arr.map(e => `
      <tr>
        <td>${e.id_peminjaman}</td>
        <td>${e.nama_peminjam}</td>
        <td>${e.nama_instansi}</td>
        <td>${e.tgl_pinjam}</td>
        <td>${e.tgl_kembali}</td>
        <td>${e.tgl_permohonan}</td>
        <td class="text-center">
          ${switchStatus(e.status)}
        </td>
        <td class="text-center">
          <a href="<?= base_url() ?>/user/peminjaman/status/${e.id_peminjaman}">
            <button class="btn btn-primary btn-xs">Detail</button>
          </a>
        </td>
      </tr>
    `)
  }

  $.ajax({
    url: '<?= base_url() ?>/api/peminjaman',
    method: 'GET',
    success: (data) => {
      $('#tbody').html(arrToEle(data))
      $('#dtb').DataTable({
        responsive: true
      });
    }
  })
</script>

<?= $this->endSection('content') ?>