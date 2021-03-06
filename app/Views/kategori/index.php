<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/kategori'); ?>">Kategori</a></li>
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
        <a href="<?= base_url('admin/kategori/tambah') ?>" class="btn btn-primary btn-sm">Tambah</a>
        <!-- <a href="<?= base_url('admin/kategori/cetak') ?>" class="btn btn-success btn-sm">Cetak</a> -->
      </div>
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <td>No.</td>
              <td>ID Kategori</td>
              <td>Nama kategori</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($kategori as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_kategori'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/kategori/edit/' . $row['id_kategori']) ?>" style="text-decoration: none !important;">
                    <button class="btn btn-success btn-xs">
                      Edit
                    </button>
                  </a>
                  <button class="btn btn-danger btn-xs hapus" kode="<?= $row['id_kategori'] ?>" name="<?= $row['nama_kategori'] ?>">Hapus</button>
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
        <input type="hidden" name="idhapus" id="idhapus">
        <p>Apakah anda yakin ingin menghapus kategori <strong class="text-konfirmasi"> </strong> ?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success btn-xs" data-dismiss="modal">Batal</button>
        <button id="konfirmasi" class="btn btn-danger btn-xs">Hapus</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(".hapus").click((e) => {
    const kode = e.target.getAttribute('kode')
    const name = e.target.getAttribute('name')

    $(".text-konfirmasi").text(name)
    $("#idhapus").val(kode)
    $("#myModal").modal("show")
  })

  $("#konfirmasi").click(() => {
    $.ajax({
      url: `<?= base_url('admin/kategori/hapus') ?>/${$("#idhapus").val()}`,
      type: "GET",
      error: (err) => {
        console.log(err)
      },
      success: (html) => {
        location.href = "<?= base_url('admin/kategori') ?>"
      }
    });
  });
</script>

<?= $this->endSection('content') ?>