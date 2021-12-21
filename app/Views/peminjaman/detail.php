<?= $this->extend('template_user') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('user/peminjaman'); ?>">Peminjaman</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div id="alert"></div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Detail Data Peminjaman
      </div>
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <td>ID</td>
              <td>Foto</td>
              <td>Nama</td>
              <td>Kategori</td>
              <td>Deskripsi</td>
            </tr>
          </thead>
          <tbody id="tbody">
            <?php foreach ($inventaris as $row) : ?>
              <tr>
                <td><?= $row['id_inventaris'] ?></td>
                <td>
                  <img src="<?= base_url('files/inventaris/' . $row['foto']) ?>" width="100px" height="100px">
                </td>
                <td><?= $row['nama_inventaris'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>

        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_peminjam">Nama Peminjam</label>
            <div class="col-sm-10">
              <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control" value="<?= $peminjam['nama_peminjam'] ?>" readonly placeholder="Nama Peminjam">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_instansi">Nama Instansi</label>
            <div class="col-sm-10">
              <input type="text" value="<?= $peminjam['nama_instansi'] ?>" readonly id="nama_instansi" name="nama_instansi" class="form-control" required placeholder="Nama Instansi">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="no_hp">No. HP</label>
            <div class="col-sm-10">
              <input type="text" value="<?= $peminjam['no_hp'] ?>" readonly id="no_hp" name="no_hp" class="form-control" required placeholder="No. HP">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_pinjam" class="col-sm-2 text-left">Tanggal Pinjam</label>
            <div class="col-sm-10">
              <input type="date" value="<?= $peminjaman['tgl_pinjam'] ?>" readonly name="tgl_pinjam" class="form-control" required placeholder="Tanggal Pinjam" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_kembali" class="col-sm-2 text-left">Tanggal Kembali</label>
            <div class="col-sm-10">
              <input type="date" value="<?= $peminjaman['tgl_kembali'] ?>" readonly name="tgl_kembali" class="form-control" placeholder="Tanggal Kembali" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_permohonan" class="col-sm-2 text-left">Tanggal Permohonan</label>
            <div class="col-sm-10">
              <input type="date" value="<?= $peminjaman['tgl_permohonan'] ?>" readonly name="tgl_permohonan" class="form-control" placeholder="Tanggal Permohonan" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="keperluan" class="col-sm-2 text-left">Keperluan</label>
            <div class="col-sm-10">
              <textarea name="keperluan" readonly id="keperluan" class="form-control" placeholder="Keperluan"><?= $peminjaman['keperluan'] ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="surat_peminjaman" class="col-sm-2 mt-2 text-left">Surat</label>
            <div class="col-sm-10">
              <a href="<?= base_url('files/surat/' . $peminjaman['surat_peminjaman']) ?>"><?= $peminjaman['surat_peminjaman'] ?></a>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: center;">
            <?php if ($peminjaman['status'] === 'pending') : ?>
              <button type="button" class="btn btn-danger btn-sm" onclick="batal()">Batal</button>
            <?php endif ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  const id_peminjaman = '<?= $peminjaman['id_peminjaman'] ?>'

  const batal = () => {
    $.ajax({
      url: `<?= base_url() ?>/api/peminjaman/${id_peminjaman}/batal`,
      method: 'GET',
      error: (data) => {
        $('#alert').html(`<div class="alert alert-danger">${data.responseJSON.error}</div>`)
      },
      success: (data) => {
        window.location.replace('<?= base_url('user/peminjaman/status') ?>')
      }
    })
  }
</script>

<?= $this->endSection('content') ?>