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
                <td><?= $row['nama_ruangan'] ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_permohonan'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_pinjam'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_kembali'])) ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/ruangan/edit/' . $row['id_ruangan']) ?>" style="text-decoration: none !important;">
                    <button class="btn btn-warning btn-xs">
                      Detail
                    </button>
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