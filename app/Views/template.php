<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" href="<?= base_url('img/Logo SKB.PNG') ?>" type="image/png" />

  <title><?= $title ?></title>

  <!-- Bootstrap Core CSS -->
  <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

  <!-- Bootstrap Core CSS -->
  <link href="<?= base_url('css/datepicker.css') ?>" rel="stylesheet">

  <!-- Custom Isi CSS -->
  <link href="<?= base_url('vendor/bootstrap/css/custom.css') ?>" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?= base_url('vendor/metisMenu/metisMenu.min.css'); ?>" rel="stylesheet">

  <!-- DataTables CSS -->
  <link href="<?= base_url('vendor/datatables-plugins/dataTables.bootstrap.css') ?>" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="<?= base_url('vendor/datatables-responsive/dataTables.responsive.css') ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?= base_url('dist/css/sb-admin-2.css') ?>" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?= base_url('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

  <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/sb-admin-2.js') ?>"></script>

  <style>
    #page-wrapper {
      min-height: 94vh;
    }
  </style>
</head>

<body>
  <?= $this->include('layouts/navbar') ?>
  <div id="page-wrapper">
    <?= $this->renderSection('content') ?>
  </div>

  <!-- Bootstrap -->
  <script src="<?= base_url('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>

  <!-- Metis Menu -->
  <script src="<?= base_url('vendor/metisMenu/metisMenu.min.js') ?>"></script>
  
  <!-- DataTables -->
  <script src="<?= base_url('vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('vendor/datatables-plugins/dataTables.bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('vendor/datatables-responsive/dataTables.responsive.js') ?>"></script>

  <script>
    $(document).ready(function() {
      $('#dataTables-example').DataTable({
        responsive: true
      });
    });
  </script>
</body>

</html>