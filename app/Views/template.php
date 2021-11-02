<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

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

  <!-- Morris Charts CSS -->
  <link href="<?= base_url('vendor/morrisjs/morris.css') ?>" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?= base_url('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="wrapper">
    <?= $this->include('layouts/navbar') ?>
    <div id="page-wrapper">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- JQuery -->
  <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>

  <!-- Bootstrap -->
  <script src="<?= base_url('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>

  <!-- Metis Menu -->
  <script src="<?= base_url('vendor/metisMenu/metisMenu.min.js') ?>"></script>

  <!-- Morris Charts -->
  <script src="<?= base_url('vendor/raphael/raphael.min.js') ?>"></script>
  <script src="<?= base_url('vendor/morrisjs/morris.min.js') ?>"></script>
  <script src="<?= base_url('data/morris-data.js') ?>"></script>

  <!-- DataTables -->
  <script src="<?= base_url('vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('vendor/datatables-plugins/dataTables.bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('vendor/datatables-responsive/dataTables.responsive.js') ?>"></script>

  <!-- Custom Theme JavaScript -->
  <script src="<?= base_url('dist/js/sb-admin-2.js') ?>"></script>
</body>

</html>