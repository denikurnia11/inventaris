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
        Masukkan Data Peminjaman
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
          </tbody>
        </table>

        <form method="POST" enctype="multipart/form-data" onsubmit="handleSubmit(event)" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_peminjam">Nama Peminjam</label>
            <div class="col-sm-10">
              <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control" required placeholder="Nama Peminjam">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_instansi">Nama Instansi</label>
            <div class="col-sm-10">
              <input type="text" id="nama_instansi" name="nama_instansi" class="form-control" required placeholder="Nama Instansi">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="no_hp">No. HP</label>
            <div class="col-sm-10">
              <input type="text" id="no_hp" name="no_hp" class="form-control" required placeholder="No. HP">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_pinjam" class="col-sm-2 text-left">Tanggal Pinjam</label>
            <div class="col-sm-10">
              <input type="date" name="tgl_pinjam" class="form-control" required placeholder="Tanggal Pinjam" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="tgl_kembali" class="col-sm-2 text-left">Tanggal Kembali</label>
            <div class="col-sm-10">
              <input type="date" name="tgl_kembali" class="form-control" placeholder="Tanggal Kembali" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="keperluan" class="col-sm-2 text-left">Keperluan</label>
            <div class="col-sm-10">
              <textarea name="keperluan" id="keperluan" class="form-control" placeholder="Keperluan"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="surat_peminjaman" class="col-sm-2 mt-2 text-left">Surat</label>
            <div class="col-sm-10">
              <input id="surat_peminjaman" type="file" name="surat_peminjaman" class="form-control btn-file">
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

<script type="text/javascript">
  // Retrieve list from localStorage
  const list = JSON.parse(localStorage.getItem('list'))

  // convert Inventaris to Data Table
  const arrToEle = (arr) => {
    return arr.map(e => `
      <tr>
        <td>${e.id_inventaris}</td>
        <td>
          <img src="<?= base_url('files/inventaris') ?>/${e.foto}" width="100px" height="100px">
        </td>
        <td>${e.nama_inventaris}</td>
        <td>${e.nama_kategori}</td>
        <td>${e.deskripsi}</td>
      </tr>
    `)
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    const form = new FormData(e.target);

    form.append('inventaris', JSON.stringify(list.map(e => e.id_inventaris)))
    form.append('id_user', '<?= session()->idUser ?>')

    $.ajax({
      url: '<?= base_url() ?>/api/peminjaman',
      method: 'POST',
      data: form,
      contentType: false,
      processData: false,
      error: (data) => {
        if (data.responseJSON.errors) {
          for (const [key, value] of Object.entries(data.responseJSON.errors)) {
            $('#alert').html(`<div class="alert alert-danger">${key}, ${value}</div>`)
          }
        } else {
          $('#alert').html(`<div class="alert alert-danger">${data.responseJSON.message}</div>`)
        }
      },
      success: (data) => {
        window.location.replace('<?= base_url('user/peminjaman/status') ?>')
      }
    })
  }

  $('#tbody').html(arrToEle(list))
</script>

<?= $this->endSection('content') ?>