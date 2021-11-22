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

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Masukkan Data Peminjaman
      </div>
      <div class="panel-body">
        <form method="POST" action="<?= base_url('user/ruangan/save/' . $ruangan['id_ruangan']) ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_ruangan">Nama Ruangan</label>
            <div class="col-sm-10">
              <input type="text" id="nama_ruangan" name="nama_ruangan" value="<?= $ruangan['nama_ruangan'] ?>" readonly class="form-control" placeholder="Nama Ruangan">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_peminjam">Nama Peminjam</label>
            <div class="col-sm-10">
              <input type="text" id="nama_peminjam" name="nama_peminjam" value="<?= old('nama_peminjam') ?>" class="form-control <?= ($validasi->hasError('nama_peminjam')) ? 'is-invalid' : '' ?>" placeholder="Nama Peminjam">
              <div class="invalid-feedback">
                <?= $validasi->getError('nama_peminjam'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_instansi">Nama Instansi</label>
            <div class="col-sm-10">
              <input type="text" id="nama_instansi" name="nama_instansi" value="<?= old('nama_instansi') ?>" class="form-control <?= ($validasi->hasError('nama_instansi')) ? 'is-invalid' : '' ?>" placeholder="Nama Instansi">
              <div class="invalid-feedback">
                <?= $validasi->getError('nama_instansi'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="no_hp">No. HP</label>
            <div class="col-sm-10">
              <input type="text" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" class="form-control <?= ($validasi->hasError('no_hp')) ? 'is-invalid' : '' ?>" placeholder="No. HP">
              <div class="invalid-feedback">
                <?= $validasi->getError('no_hp'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_pinjam" class="col-sm-2 text-left">Tanggal Pinjam</label>
            <div class="col-sm-10">
              <input type="date" name="tgl_pinjam" value="<?= old('tgl_pinjam') ?>" class="form-control <?= ($validasi->hasError('tgl_pinjam')) ? 'is-invalid' : '' ?>" placeholder="Tanggal Pinjam" min="0">
              <div class="invalid-feedback">
                <?= $validasi->getError('tgl_pinjam'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_kembali" class="col-sm-2 text-left">Tanggal Kembali</label>
            <div class="col-sm-10">
              <input type="date" name="tgl_kembali" value="<?= old('tgl_kembali') ?>" class="form-control <?= ($validasi->hasError('tgl_kembali')) ? 'is-invalid' : '' ?>" placeholder="Tanggal Kembali" min="0">
              <div class="invalid-feedback">
                <?= $validasi->getError('tgl_kembali'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="keperluan" class="col-sm-2 text-left">Keperluan</label>
            <div class="col-sm-10">
              <textarea name="keperluan" id="keperluan" class="form-control <?= ($validasi->hasError('keperluan')) ? 'is-invalid' : '' ?>" placeholder="Keperluan"><?= old('keperluan') ?></textarea>
              <div class="invalid-feedback">
                <?= $validasi->getError('keperluan'); ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="surat_peminjaman" class="col-sm-2 mt-2 text-left">Surat</label>
            <div class="col-sm-10">
              <input id="surat_peminjaman" type="file" name="surat_peminjaman" class="form-control btn-file <?= ($validasi->hasError('deskripsi')) ? 'is-invalid' : '' ?>">
              <div class="invalid-feedback">
                <?= $validasi->getError('surat_peminjaman'); ?>
              </div>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('user/ruangan') ?>">
              <button type="button" class="btn btn-danger btn-sm" style="margin-right: 1rem;">Kembali</button>
            </a>
            <button type="submit" class="btn btn-success btn-sm">Pinjam</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>