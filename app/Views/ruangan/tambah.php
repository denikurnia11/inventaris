<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/ruangan') ?>">Ruangan</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Masukkan Data Ruangan
      </div>
      <div class="panel-body">
        <form method="POST" action="<?= base_url('admin/ruangan/save') ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_ruangan">Nama Ruangan</label>
            <div class="col-sm-10">
              <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control" placeholder="Nama Ruangan">
            </div>
          </div>

          <div class="form-group">
            <label for="kapasitas" class="col-sm-2 text-left">Kapasitas</label>
            <div class="col-sm-10">
              <input type="number" name="kapasitas" class="form-control" placeholder="Kapasitas" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="deskripsi" class="col-sm-2 text-left">Deskripsi</label>
            <div class="col-sm-10">
              <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('admin/ruangan') ?>">
              <button type="button" class="btn btn-danger btn-sm" style="margin-right: 1rem;">Kembali</button>
            </a>
            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>