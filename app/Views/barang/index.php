<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />

    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('barang'); ?>">Barang</a></li>
      <li class="active">Data Barang</li>
    </ol>

    <?php

    if (!empty($message)) {
      echo $message;
    }
    ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary btn-sm">Tambah</a>
        <a href="<?= base_url('laporan/cetak_barang') ?>" class="btn btn-primary btn-sm">Cetak</a>
      </div>
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
              <td>Tanggal Perolehan</td>
              <td>Harga</td>
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
                  <img src="<?= base_url('assets/img/barang/barang-default.jpg'); ?>" width="100px" height="100px">
                </td>
                <td><?= $row['id_barang'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jml_barang'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['tgl_perolehan'] ?></td>
                <td><?= $row['harga'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td class="text-center">
                  <a href="#">
                    <button class="btn btn-success btn-xs">
                      Ubah
                    </button>
                  </a>
                  <button href="#" class="hapus btn btn-danger btn-xs">Hapus</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idhapus" id="idhapus">
        <p>Apakah anda yakin ingin menghapus barang <strong class="text-konfirmasi"> </strong> ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-xs" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger btn-xs" id="konfirmasi">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


<!-- <script type="text/javascript">
  $(function() {
    $(".hapus").click(function() {
      var kode = $(this).attr("kode");
      var name = $(this).attr("name");

      $(".text-konfirmasi").text(name)
      $("#idhapus").val(kode);
      $("#myModal").modal("show");
    });

    $("#konfirmasi").click(function() {
      var kode_barang = $("#idhapus").val();

      $.ajax({
        url: "<?php echo site_url('barang/delete'); ?>",
        type: "POST",
        data: "kode_barang=" + kode_barang,
        cache: false,
        success: function(html) {
          location.href = "<?php echo site_url('barang/index/delete-success'); ?>";
        }
      });
    });
  });
</script> -->

<?= $this->endSection('content') ?>