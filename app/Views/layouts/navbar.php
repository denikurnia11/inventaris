<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?= base_url('dashboard'); ?>"><strong>SKB</strong></a>
  </div>
  <ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>
        <?= 'Admin' ?>
        <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
          <a href="#"><i class="fa fa-folder fa-fw"></i> Data Master<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('admin/barang'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Barang</a>
            </li>
            <li>
              <a href="<?= base_url('admin/ruangan'); ?>"><i class="fa fa-archive fa-fw"></i> Data Ruangan</a>
            </li>
            <li>
              <a href="<?= base_url('admin/kategori'); ?>"><i class="fa fa-list fa-fw"></i> Data Kategori</a>
            </li>
            <li>
              <a href="<?= base_url('admin/user'); ?>"><i class="glyphicon glyphicon-user"></i> Data User</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="fa fa-book fa-fw"></i> Daftar Peminjaman<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('admin/laporan'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Barang</a>
            </li>
            <li>
              <a href="<?= base_url('admin/laporan'); ?>"><i class="fa fa-archive fa-fw"></i> Data Ruangan</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="fa fa-file-text fa-fw"></i> Laporan<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('admin/laporan'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Barang</a>
            </li>
            <li>
              <a href="<?= base_url('admin/laporan'); ?>"><i class="fa fa-archive fa-fw"></i> Data Ruangan</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="<?= base_url('login/logout') ?>"><i class="fa fa-power-off fa-fw"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>