<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/barang'); ?>">Barang</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Masukkan Data Barang
      </div>
      <div class="panel-body">
        <form method="POST" action="<?= base_url('admin/barang/save') ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_barang">Nama Barang</label>
            <div class="col-sm-10">
              <input type="text" id="nama_barang" name="nama_barang" value="<?= old('nama_barang') ?>" class="form-control <?= ($validasi->hasError('nama_barang')) ? 'is-invalid' : '' ?>" placeholder="Nama Barang">
              <div class="invalid-feedback">
                <?= $validasi->getError('nama_barang'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="kategori" class="col-sm-2 text-left">Kategori</label>
            <div class="col-sm-10">
              <select name="id_kategori" value="<?= old('id_kategori') ?>" id="kategori" class="form-control <?= ($validasi->hasError('id_kategori')) ? 'is-invalid' : '' ?>">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori as $row) : ?>
                  <option <?= $row['id_kategori'] == old('id_kategori') ? 'selected' : '' ?> value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                <?php endforeach ?>
              </select>
              <div class="invalid-feedback">
                <?= $validasi->getError('id_kategori') ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="jml_barang" class="col-sm-2 text-left">Jumlah</label>
            <div class="col-sm-10">
              <input type="number" name="jml_barang" value="<?= old('jml_barang') ?>" class="form-control <?= ($validasi->hasError('jml_barang')) ? 'is-invalid' : '' ?>" placeholder="Jumlah" min="0">
              <div class="invalid-feedback">
                <?= $validasi->getError('jml_barang'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="harga" class="col-sm-2 text-left">Harga</label>
            <div class="col-sm-10">
              <input type="number" name="harga" value="<?= old('harga') ?>" id="harga" class="form-control <?= ($validasi->hasError('harga')) ? 'is-invalid' : '' ?>" placeholder="Harga" min="0">
              <div class="invalid-feedback">
                <?= $validasi->getError('harga'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_perolehan" class="col-sm-2 text-left">Tanggal Perolehan</label>
            <div class="col-sm-10">
              <input type="date" id="tgl_perolehan" value="<?= old('tgl_perolehan') ?>" name="tgl_perolehan" class="form-control <?= ($validasi->hasError('tgl_perolehan')) ? 'is-invalid' : '' ?>" placeholder="Tanggal Perolehan">
              <div class="invalid-feedback">
                <?= $validasi->getError('tgl_perolehan'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="deskripsi" class="col-sm-2 text-left">Deskripsi</label>
            <div class="col-sm-10">
              <textarea name="deskripsi" id="deskripsi" class="form-control <?= ($validasi->hasError('deskripsi')) ? 'is-invalid' : '' ?>" placeholder="Deskripsi"><?= old('deskripsi') ?></textarea>
              <div class="invalid-feedback">
                <?= $validasi->getError('deskripsi'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="foto" class="col-sm-2 mt-2 text-left">Gambar</label>
            <div class="col-sm-10">
              <input id="foto" type="file" name="foto" class="form-control btn-file <?= ($validasi->hasError('deskripsi')) ? 'is-invalid' : '' ?>">
              <div class="invalid-feedback">
                <?= $validasi->getError('foto'); ?>
              </div>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('admin/barang') ?>">
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