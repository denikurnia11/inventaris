<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/kategori') ?>">Kategori</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Masukkan Data Kategori
      </div>
      <div class="panel-body">
        <form method="POST" action="<?= base_url('admin/kategori/update/' . $kategori['id_kategori']) ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_kategori">Nama Kategori</label>
            <div class="col-sm-10">
              <input type="text" id="nama_kategori" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" class="form-control <?= ($validasi->hasError('nama_kategori')) ? 'is-invalid' : '' ?>" placeholder="Nama Kategori">
              <div class="invalid-feedback">
                <?= $validasi->getError('nama_kategori') ?>
              </div>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('admin/kategori') ?>">
              <button type="button" class="btn btn-danger btn-sm" style="margin-right: 1rem;">Kembali</button>
            </a>
            <button type="submit" class="btn btn-success btn-sm">Edit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>