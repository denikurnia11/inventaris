<!DOCTYPE html>
<?php
$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Laporan">
  <title><?= $title ?></title>
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/sheets-of-paper-a4.css') ?>">
  <style>
    body {
      -webkit-print-color-adjust: exact;
    }

    .table {
      border: 2px solid black;
      width: 100%;
      border-collapse: collapse;
      margin: 16px 0;
      font-size: 12px;
    }

    .table>thead>tr>th {
      border: 2px solid black;
    }

    .table>tbody>tr>td {
      border: 2px solid black;
      vertical-align: top;
    }
  </style>
</head>

<body class="document">
  <div class="page" contenteditable="false">
    <div style="display: flex; justify-content: center;">
      <div>
        <img src="<?= base_url('img/Logo SKB.PNG') ?>" alt="logo skb" width="150" height="150">
      </div>
      <div style="text-align: center; padding: 0;">
        <div style="font-weight: bold; font-size: 20px;">PEMERINTAH KABUPATEN HULU SUNGAI SELATAN</div>
        <div style="font-weight: bold; font-size: 20px;">DINAS PENDIDIKAN DAN KEBUDAYAAN</div>
        <div style="font-weight: bold; font-size: 28px;">SPNF SKB HULU SUNGAI SELATAN</div>
        <p>Alamat: Jln Kerja Bakti No 27 - Tibung Raya Telpon (0517) 2167</p>
        <p style="margin: 0; padding: 0; margin-top: 4px;"><strong style="margin-right: 1rem;">KANDANGAN</strong> Kode Pos 71214</p>
      </div>
    </div>
    <div style="width: 100%; background: black; height: 4px; margin-top: 24px; padding: 0;"></div>
    <div style="width: 100%; background: black; height: 2px; margin-top: 2px; padding: 0;"></div>
    <table style="margin-top: 24px;" class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Inventaris</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Tanggal Perolehan</th>
          <th>Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($inventaris as $row) : ?>
          <tr>
            <th scope="row"><?= $no++ ?></th>
            <td><?= $row['nama_inventaris'] ?></td>
            <td><?= $row['nama_kategori'] ?></td>
            <td><?= $fmt->formatCurrency($row['harga'], "IDR") ?></td>
            <td><?= $row['tgl_perolehan'] ?></td>
            <td><?= $row['deskripsi'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="display: flex; justify-content: end; width: 100%;">
      <div>
        <div>Kandangan,</div>
        <div>Kepala SPNF SKB HSS</div>
        <br>
        <br>
        <br>
        <div>Drs. Eddy Rakmad, M.Pd</div>
        <div>NIP.1967018.199512.1.003</div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    window.print();
    setTimeout(() => {
      location.replace('<?= base_url('admin/inventaris') ?>')
    }, 5000)
  </script>
</body>

</html>