<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
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
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>
        <?= 'User' ?>
        <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="<?= base_url('logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
      </ul>
    </li>
  </ul>
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <!-- <li>
          <a href="<?= base_url('dashboard'); ?>"><i class="fa fa-home fa-fw"></i> Halaman Utama</a>
        </li> -->
        <li>
          <a href="#"><i class="fa fa-folder fa-fw"></i> Peminjaman<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('user/barang'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Barang</a>
            </li>
            <li>
              <a href="<?= base_url('user/ruangan'); ?>"><i class="fa fa-archive fa-fw"></i> Data Ruangan</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="fa fa-comment fa-fw"></i> Status Peminjaman<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('user/status/barang'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Barang</a>
            </li>
            <li>
              <a href="<?= base_url('user/status/ruangan'); ?>"><i class="fa fa-archive fa-fw"></i> Data Ruangan</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="<?= base_url('logout') ?>"><i class="fa fa-power-off fa-fw"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>