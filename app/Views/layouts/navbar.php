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
        <?= 'Admin' ?>
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
        <li>
          <a href="#"><i class="fa fa-folder fa-fw"></i> Data Master<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="<?= base_url('admin/inventaris'); ?>"><i class="fa fa-desktop fa-fw"></i> Data Inventaris</a>
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
          <a href="<?= base_url('admin/peminjaman/request') ?>"><i class="fa fa-comment fa-fw"></i> Request Peminjaman</a>
        </li>
        <li>
          <a href="<?= base_url('admin/peminjaman') ?>"><i class="fa fa-book fa-fw"></i> Daftar Peminjaman</a>
        </li>
        <li>
          <a href="<?= base_url('admin/peminjaman/laporan') ?>"><i class="fa fa-file-text fa-fw"></i> Laporan</a>
        </li>
        <li>
          <a href="<?= base_url('logout') ?>"><i class="fa fa-power-off fa-fw"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>