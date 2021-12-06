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

  <!-- Custom Isi CSS -->
  <link href="<?= base_url('vendor/bootstrap/css/custom.css') ?>" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="<?= base_url('vendor/datatables-responsive/dataTables.responsive.css') ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?= base_url('dist/css/sb-admin-2.css') ?>" rel="stylesheet">
  <link href="<?= base_url('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
  <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>

  <style>
    body {
      background: url('<?= base_url('img/Background SKB.jpeg') ?>');
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
      height: 100vh;
      overflow: hidden;
    }
    .card {
      background: white;
      border-radius: 1rem;
      
      padding: 2rem;
      border: 1px solid #a5a5a5;
      --tw-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="display: flex; align-items: center;" href="<?= base_url('/'); ?>">
        <img src="<?= base_url('img/Logo SKB.PNG') ?>" width="25" height="25" alt="Logo SKB">
        <strong class="ml-2">SKB</strong>
      </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
      <li class="">
        <a href="<?= base_url('login') ?>">
          Login
        </a>
      </li>
      <li class="">
        <a href="<?= base_url('daftar') ?>">
          Daftar
        </a>
      </li>
    </ul>
  </nav>

  <div class="row p-5 mt-md-5 d-flex align-items-center justify-content-center">
    <div class="col-xs-12 col-sm-6 col-lg-3 mx-auto row mt-md-5 text-center card">
      <h1 class="mb-5">Login</h1>
      <!-- FlashData -->
      <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-danger text-start d-flex justify-content-between align-items-center" role="alert">
          <?= session()->getFlashdata('pesan'); ?>
        </div>
      <?php endif; ?>
      <form action="<?= base_url('auth/login/cek') ?>" method="POST" class="my-4">
        <div class="form-group mb-4 text-left">
          <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?>" class="form-control <?= ($validasi->hasError('username')) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback">
            <?= $validasi->getError('username'); ?>
          </div>
        </div>
        <div class="form-group mb-4 text-left">
          <input type="password" name="password" id="password" placeholder="Password" value="<?= old('password') ?>" class="form-control <?= ($validasi->hasError('password')) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback">
            <?= $validasi->getError('password'); ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-5" style="width: 100%;">Login</button>
        <p class="mt-5">Belum punya akun? <a href="<?= base_url('daftar') ?>">Daftar</a></p>
      </form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="<?= base_url('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
  <!-- Metis Menu -->
  <script src="<?= base_url('vendor/metisMenu/metisMenu.min.js') ?>"></script>
</body>

</html>