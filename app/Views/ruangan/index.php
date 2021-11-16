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

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="<?= base_url('admin/ruangan/tambah') ?>" class="btn btn-primary btn-sm">Tambah</a>
      </div>
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <td>No.</td>
              <td>ID Ruangan</td>
              <td>Nama Ruangan</td>
              <td>Kapasitas</td>
              <td>Deskripsi</td>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($ruangan as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_ruangan'] ?></td>
                <td><?= $row['nama_ruangan'] ?></td>
                <td><?= $row['kapasitas'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/ruangan/edit/' . $row['id_ruangan']) ?>" style="text-decoration: none !important;">
                    <button class="btn btn-success btn-xs">
                      Edit
                    </button>
                  </a>
                  <button class="btn btn-danger btn-xs hapus" kode="<?= $row['id_ruangan'] ?>" name="<?= $row['nama_ruangan'] ?>">Hapus</button>
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
        <p>Apakah anda yakin ingin menghapus ruangan <strong class="text-konfirmasi"> </strong> ?</p>
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
      url: `<?= base_url('admin/ruangan/hapus') ?>/${$("#idhapus").val()}`,
      type: "GET",
      error: (err) => {
        console.log(err)
      },
      success: (html) => {
        location.href = "<?= base_url('admin/ruangan') ?>"
      }
    });
  });
</script>

<?= $this->endSection('content') ?>