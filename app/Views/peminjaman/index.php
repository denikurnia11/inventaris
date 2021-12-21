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

<?php if (session()->getFlashData('pesan')) : ?>
  <div class="alert alert-success" role="alert"><?= session()->getFlashData('pesan') ?></div>
<?php endif; ?>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dtb">
          <thead>
            <tr>
              <td>ID</td>
              <td>Foto</td>
              <td>Nama</td>
              <td>Kategori</td>
              <td>Deskripsi</td>
              <td>Pinjam</td>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr>
              <td>12</td>
              <td>
                <img src="<?= base_url('/files/barang/barang-default.jpg') ?>" width="100px" height="100px">
              </td>
              <td>Acer Nitro 42</td>
              <td>Laptop</td>
              <td>laptop gimang sejuta umat</td>
              <td class="text-center">
                <button class="btn btn-primary btn-xs">Pinjam</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-primary" onclick="pinjam()">Pinjam</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  // convert PHP Array to JSON format
  const inventaris = <?= json_encode($inventaris) ?>; // for some reason this line need semicolon on it
  let list = []

  const addList = (id) => {
    if (list.indexOf(id) === -1) list.push(id)
  }

  const removeList = (id) => {
    list = list.filter(e => e === id)
  }

  const updateList = (e) => {
    if (e.checked) addList(e.value)
    else removeList(e)
  }

  // convert Inventaris to Data Table
  const arrToEle = (arr) => {
    return arr.map(e => `
      <tr>
        <td>${e.id_inventaris}</td>
        <td>
          <img src="<?= base_url('/files/inventaris') ?>/${e.foto}" width="100px" height="100px">
        </td>
        <td>${e.nama_inventaris}</td>
        <td>${e.nama_kategori}</td>
        <td>${e.deskripsi}</td>
        <td class="text-center">
          <input type="checkbox" name="id" value="${e.id_inventaris}" onchange="updateList(this)">
        </td>
      </tr>
    `)
  }

  // refresh data table with new data
  const init = () => {
    // Filter the data not in the list
    $('#tbody').html(arrToEle(inventaris).join(''))
    $('#dtb').DataTable({
      responsive: true
    });
  }

  // store data to localStorage and redirect to 'form pinjam'
  const pinjam = () => {
    if (!list.length) return alert('Silahkan pilih barang/ruangan')
    localStorage.clear()
    localStorage.setItem('list', JSON.stringify(inventaris.filter(e => list.indexOf(e.id_inventaris) !== -1)))
    window.location.replace('<?= base_url('user/peminjaman/pinjam') ?>')
  }

  init()
</script>

<?= $this->endSection('content') ?>