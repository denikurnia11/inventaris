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
      <li><a href="<?= base_url('user/barang'); ?>">Barang</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
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
              <td>Nama Instansi</td>
              <td>Nama Barang</td>
              <td>Jumlah Pinjam</td>
              <td>Tanggal Pinjam</td>
              <td>Status</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($peminjaman as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_peminjaman'] ?></td>
                <td><?= $row['nama_peminjam'] ?></td>
                <td><?= $row['nama_instansi'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jml_barang'] ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_pinjam'])) ?></td>
                <td class="text-center" style="text-transform: capitalize;">
                  <div class="<?= badge($row['status']) ?>">
                    <?= $row['status'] ?>
                  </div>
                </td>
                <td class="text-center">
                  <?php if ($row['status'] == 'pending') : ?>
                    <button class="btn btn-danger btn-xs" onclick="batalkan(<?= $row['id_peminjaman'] ?>)">Batalkan</button>
                  <?php elseif ($row['status'] == 'disetujui') : ?>
                    <button class="btn btn-info btn-xs" onclick="lihat(<?= $row['id_peminjaman'] ?>)">Lihat</button>
                  <?php endif; ?>
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
  const batalkan = (id) => {
    window.location.replace(`<?= base_url('user/barang/batal') ?>/${id}`)
  }

  const lihat = (id) => {
    window.location.replace(`<?= base_url('user/barang/cetak') ?>/${id}`)
  }
</script>

<?= $this->endSection('content') ?>