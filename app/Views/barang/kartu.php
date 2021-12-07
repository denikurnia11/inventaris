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

  <title>Kartu Peminjaman Barang SKB HSS</title>
</head>

<body>
  <div style="text-align: center; font-weight: bold;">Kartu Peminjaman Barang SKB HSS</div>
  <div>Nama Peminjam: <?= $peminjaman['nama_peminjam'] ?></div>
  <div>Nama Instansi: <?= $peminjaman['nama_instansi'] ?> </div>
  <div>No. HP: <?= $peminjaman['no_hp'] ?> </div>
  <div>Nama Barang: <?= $peminjaman['nama_barang'] ?> </div>
  <div>Jumlah Pinjam: <?= $peminjaman['jml_barang'] ?> </div>
  <div>Tanggal Pinjam: <?= $peminjaman['tgl_pinjam'] ?> </div>
  <div>Tanggal Kembali: <?= $peminjaman['tgl_kembali'] ?> </div>
  <div>Keperluan: <?= $peminjaman['keperluan'] ?> </div>

  <script type="text/javascript">
    window.print();

    setTimeout(() => {
      window.location.replace('<?= base_url('user/status/barang') ?>')
    }, 3000);
  </script>
</body>

</html>