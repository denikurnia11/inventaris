<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/barang'); ?>">Barang</a></li>
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
        <form method="POST" action="<?= base_url('admin/barang/update') ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_barang">Nama Barang</label>
            <div class="col-sm-10">
              <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?= $barang['nama_barang'] ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="kategori" class="col-sm-2 text-left">Kategori</label>
            <div class="col-sm-10">
              <select name="id_kategori" id="kategori" class="form-control">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori as $row) : ?>
                  <option <?= $row['id_kategori'] == $barang['id_kategori'] ? 'selected' : '' ?> value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="jml_barang" class="col-sm-2 text-left">Jumlah</label>
            <div class="col-sm-10">
              <input value="<?= $barang['jml_barang'] ?>" type="number" name="jml_barang" class="form-control" placeholder="Jumlah" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="harga" class="col-sm-2 text-left">Harga</label>
            <div class="col-sm-10">
              <input type="number" value="<?= $barang['harga'] ?>" name="harga" id="harga" class="form-control" placeholder="Harga" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_perolehan" class="col-sm-2 text-left">Tanggal Perolehan</label>
            <div class="col-sm-10">
              <input value="<?= $barang['tgl_perolehan'] ?>" type="date" id="tgl_perolehan" name="tgl_perolehan" class="form-control" placeholder="Tanggal Perolehan">
            </div>
          </div>

          <div class="form-group">
            <label for="deskripsi" class="col-sm-2 text-left">Deskripsi</label>
            <div class="col-sm-10">
              <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi"><?= $barang['deskripsi'] ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="foto" class="col-sm-2 mt-2 text-left">Gambar</label>
            <div class="col-sm-10">
              <input id="foto" type="file" name="foto" class="form-control btn-file">
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('admin/barang') ?>">
              <button type="button" class="btn btn-danger btn-sm" style="margin-right: 1rem;">Kembali</button>
            </a>
            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>