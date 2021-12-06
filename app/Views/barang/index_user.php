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
              <td>Foto</td>
              <td>ID Barang</td>
              <td>Nama Barang</td>
              <td>Jumlah</td>
              <td>Kategori</td>
              <td>Deskripsi</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($barang as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td>
                  <?php if (!!$row['foto']) : ?>
                    <img src="<?= base_url('/files/barang/' . $row['foto']) ?>" width="100px" height="100px">
                  <?php else : ?>
                    <img src="<?= base_url('/files/barang/barang-default.jpg') ?>" width="100px" height="100px">
                  <?php endif; ?>
                </td>
                <td><?= $row['id_barang'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jml_barang'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td class="text-center">
                  <a href="<?= base_url('user/barang/pinjam/' . $row['id_barang']) ?>">
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