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
      <div class="panel-heading">
        Detail Data Peminjaman
      </div>
      <div class="panel-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="id_peminjam">ID Peminjam</label>
            <div class="col-sm-10">
              <input type="text" id="id_peminjam" name="id_peminjam" value="<?= $peminjam['id_peminjam'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_peminjam">Nama Peminjam</label>
            <div class="col-sm-10">
              <input type="text" id="nama_peminjam" name="nama_peminjam" value="<?= $peminjam['nama_peminjam'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_instansi">Nama Instansi</label>
            <div class="col-sm-10">
              <input type="text" id="nama_instansi" name="nama_instansi" value="<?= $peminjam['nama_instansi'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="no_hp">No. HP</label>
            <div class="col-sm-10">
              <input type="text" id="no_hp" name="no_hp" value="<?= $peminjam['no_hp'] ?>" readonly class="form-control">
            </div>
          </div>

          <hr />

          <div class="form-group">
            <label class="col-sm-2 text-left" for="id_ruangan">ID Ruangan</label>
            <div class="col-sm-10">
              <input type="text" id="id_ruangan" name="id_ruangan" value="<?= $ruangan['id_ruangan'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_ruangan">Nama Ruangan</label>
            <div class="col-sm-10">
              <input type="text" id="nama_ruangan" name="nama_ruangan" value="<?= $ruangan['nama_ruangan'] ?>" readonly class="form-control">
            </div>
          </div>

          <hr />

          <div class="form-group">
            <label class="col-sm-2 text-left" for="status">Status</label>
            <div class="col-sm-10">
              <input style="text-transform: capitalize;" type="text" id="status" name="status" value="<?= $peminjaman['status'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="tgl_permohonan">Tanggal Permohonan</label>
            <div class="col-sm-10">
              <input type="text" id="tgl_permohonan" name="tgl_permohonan" value="<?= $peminjaman['tgl_permohonan'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="tgl_pinjam">Tanggal Pinjam</label>
            <div class="col-sm-10">
              <input type="text" id="tgl_pinjam" name="tgl_pinjam" value="<?= $peminjaman['tgl_pinjam'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="tgl_kembali">Tanggal Kembali</label>
            <div class="col-sm-10">
              <input type="text" id="tgl_kembali" name="tgl_kembali" value="<?= $peminjaman['tgl_kembali'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="tgl_selesai">Tanggal Selesai</label>
            <div class="col-sm-10">
              <input type="text" id="tgl_selesai" name="tgl_selesai" value="<?= $peminjaman['tgl_selesai'] ?>" readonly class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="keperluan" class="col-sm-2 text-left">Keperluan</label>
            <div class="col-sm-10">
              <textarea readonly name="keperluan" id="keperluan" class="form-control"><?= $peminjaman['keperluan'] ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="surat">Surat Peminjaman</label>
            <div class="col-sm-10">
              <a href="<?= base_url('files/surat/' . $peminjaman['surat_peminjaman']) ?>"><?= $peminjaman['surat_peminjaman'] ?></a>
            </div>
          </div>

          <div class="my-5" style="display: flex; width: 100%; justify-content: center;">
            <?php if ($peminjaman['status'] == 'pending') : ?>
              <button onclick="action('setuju')" type="button" class="btn btn-success btn-sm mx-2">Setujui</button>
              <button onclick="action('tolak')" type="button" class="btn btn-danger btn-sm mx-2">Tolak</button>
            <?php elseif ($peminjaman['status'] == 'dipinjam') : ?>
              <button onclick="action('kembali')" type="button" class="btn btn-warning btn-sm mx-2">Kembali</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin <strong id="text-konfirmasi"></strong> peminjaman?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-xs" data-dismiss="modal">Batal</button>
        <button onclick="konfirmasi()" class="btn btn-success btn-xs">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  const text = {
    'setuju': 'menyetujui',
    'tolak': 'menolak',
    'kembali': 'pengembalian'
  }
  const id_peminjaman = '<?= $peminjaman['id_peminjaman'] ?>'
  let status = ''

  function action(aksi) {
    status = aksi
    $('#text-konfirmasi').text(text[aksi])
    $("#myModal").modal("show")
  }

  function konfirmasi() {
    if (!status) return

    window.location.replace(`<?= base_url('admin/peminjaman/ruangan/changeStatus') ?>/${id_peminjaman}?status=${status}`)
  }
</script>

<?= $this->endSection('content') ?>