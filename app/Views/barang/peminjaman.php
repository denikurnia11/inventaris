<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/Barang'); ?>">Barang</a></li>
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
              <td>Nama Instansi</td>
              <td>Nama Barang</td>
              <td>Jumlah Pinjam</td>
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
                <td><?= $row['nama_instansi'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jml_barang'] ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_permohonan'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_pinjam'])) ?></td>
                <td><?= date('d F Y', strtotime($row['tgl_kembali'])) ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/peminjaman/barang/' . $row['id_peminjaman']) ?>" style="text-decoration: none !important;">
                    <button class="btn btn-primary btn-xs">
                      Detail
                    </button>
                  </a>
                  <button onclick="action(<?= $row['id_peminjaman'] ?>)" class="btn btn-warning btn-xs">
                    Kembali
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
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
        <p>Apakah anda yakin barang sudah dikembalikan?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-xs" data-dismiss="modal">Batal</button>
        <button onclick="konfirmasi()" class="btn btn-success btn-xs">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  let id_peminjaman = ''

  function action(id) {
    id_peminjaman = id
    $("#myModal").modal("show")
  }

  function konfirmasi() {
    if (!id_peminjaman) return

    window.location.href = `<?= base_url('admin/peminjaman/barang/changeStatus') ?>/${id_peminjaman}?status=kembali`
  }
</script>

<?= $this->endSection('content') ?>