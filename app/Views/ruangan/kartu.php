<!DOCTYPE html>
<html lang="en">

<head>
  <title>Kartu Peminjaman Ruangan SKB HSS</title>
</head>

<body>
  <div>
    <div style="text-align: center; font-weight: bold;">Kartu Peminjaman Ruangan SKB HSS</div>
    <div>Nama Peminjam: <?= $peminjaman['nama_peminjam'] ?></div>
    <div>Nama Instansi: <?= $peminjaman['nama_instansi'] ?> </div>
    <div>No. HP: <?= $peminjaman['no_hp'] ?> </div>
    <div>Nama Ruangan: <?= $peminjaman['nama_ruangan'] ?> </div>
    <div>Tanggal Pinjam: <?= $peminjaman['tgl_pinjam'] ?> </div>
    <div>Tanggal Kembali: <?= $peminjaman['tgl_kembali'] ?> </div>
    <div>Keperluan: <?= $peminjaman['keperluan'] ?> </div>
  </div>

  <script type="text/javascript">
    window.print();

    setTimeout(() => {
      window.location.replace('<?= base_url('user/status/ruangan') ?>')
    }, 3000);
  </script>
</body>

</html>