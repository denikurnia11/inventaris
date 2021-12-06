<!DOCTYPE html>
<!--
 * HTML-Sheets-of-Paper (https://github.com/delight-im/HTML-Sheets-of-Paper)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Laporan">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/sheets-of-paper-a4.css') ?>">
  <style>
    body {
      -webkit-print-color-adjust: exact;
    }
  </style>
</head>

<body class="document">
  <div class="page" contenteditable="false">
    <div class="d-flex justify-content-center">
      <div class="pr-5 mr-5">
        <img src="<?= base_url('img/Logo SKB.PNG') ?>" alt="logo skb" width="150" height="150">
      </div>
      <div class="text-center p-0">
        <div class="font-weight-bold my-0 mb-1" style="font-size: 20px;">PEMERINTAH KABUPATEN HULU SUNGAI SELATAN</div>
        <div class="font-weight-bold my-0" style="font-size: 20px;">DINAS PENDIDIKAN DAN KEBUDAYAAN</div>
        <div class="font-weight-bold my-0" style="font-size: 28px;">SPNF SKB HULU SUNGAI SELATAN</div>
        <p>Alamat: Jln Kerja Bakti No 27 - Tibung Raya Telpon (0517) 2167</p>
        <p class="p-0 m-0"><strong class="mr-4">KANDANGAN</strong> Kode Pos 71214</p>
      </div>
    </div>
    <div style="width: 100%; background: black; height: 4px; margin-top: 24px; padding: 0;"></div>
    <div style="width: 100%; background: black; height: 2px; margin-top: 2px; padding: 0;"></div>
    <div class="row pr-5">
      <div class="col-12">
        <table class="table table-bordered mt-5">
          <thead>
            <tr>
              <th scope="col">ID Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Kategori</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Harga</th>
              <th scope="col">Tanggal Perolehan</th>
              <th scope="col">Deskripsi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($barang as $row) : ?>
              <tr>
                <th scope="row"><?= $row['id_barang'] ?></th>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['jml_barang'] ?></td>
                <td><?= $row['harga'] ?></td>
                <td><?= $row['tgl_perolehan'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="d-flex justify-content-end w-full pr-5">
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
      location.replace('<?= base_url('admin/barang') ?>')
    }, 1000)
  </script>
</body>

</html>