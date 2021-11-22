<?php
function badge($status)
{
  switch ($status) {
    case 'tersedia':
      # code...
      return 'badge badge-success';
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
      <li><a href="<?= base_url('user/ruangan'); ?>">Ruangan</a></li>
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
              <td>ID Ruangan</td>
              <td>Nama Ruangan</td>
              <td>Kapasitas</td>
              <td>Deskripsi</td>
              <td>Status</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($ruangan as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_ruangan'] ?></td>
                <td><?= $row['nama_ruangan'] ?></td>
                <td><?= $row['kapasitas'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td class="text-center" style="text-transform: capitalize;">
                  <div class="<?= badge($row['status']) ?>">
                    <?= $row['status'] ?>
                  </div>
                </td>
                <td class="text-center">
                  <a href="<?= base_url('user/ruangan/pinjam/' . $row['id_ruangan']) ?>">
                    <button class="btn btn-primary btn-xs">Pinjam</button>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>