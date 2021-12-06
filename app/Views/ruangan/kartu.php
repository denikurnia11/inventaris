<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    @media print {
      @page {
        size: 9cm 5.5cm;
      }
    }
  </style>

  <title>Document</title>
</head>

<body>
  <h4 style="text-align: center;">Kartu Peminjaman Ruangan SKB HSS</h4>
  <div>Nama Peminjam: <?= $peminjaman['nama_peminjam'] ?></div>
  <div>Nama Instansi: <?= $peminjaman['nama_instansi'] ?> </div>
  <div>No. HP: <?= $peminjaman['no_hp'] ?> </div>
  <div>Nama Ruangan: <?= $peminjaman['nama_ruangan'] ?> </div>
  <div>Tanggal Pinjam: <?= $peminjaman['tgl_pinjam'] ?> </div>
  <div>Tanggal Kembali: <?= $peminjaman['tgl_kembali'] ?> </div>
  <div>Keperluan: <?= $peminjaman['keperluan'] ?> </div>

  <script type="text/javascript">
    window.print();

    setTimeout(() => {
      window.location.replace('<?= base_url('user/status/ruangan') ?>')
    }, 3000);
  </script>
</body>

</html>