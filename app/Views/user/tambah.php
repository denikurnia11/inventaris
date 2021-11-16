<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12"><br />
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin/user') ?>">User</a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Masukkan Data User
      </div>
      <div class="panel-body">
        <form method="POST" action="<?= base_url('admin/user/save') ?>" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 text-left" for="nama_lengkap">Nama Lengkap</label>
            <div class="col-sm-10">
              <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="email">Email</label>
            <div class="col-sm-10">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="username">Username</label>
            <div class="col-sm-10">
              <input type="text" id="username" name="username" class="form-control" placeholder="Username">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="password">Password</label>
            <div class="col-sm-10">
              <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 text-left" for="password_confirm">Konfirmasi Password</label>
            <div class="col-sm-10">
              <input type="password_confirm" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi Password">
            </div>
          </div>

          <div class="form-group">
            <label for="role" class="col-sm-2 text-left">Role</label>
            <div class="col-sm-10">
              <select name="role" id="role" class="form-control">
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
            </div>
          </div>

          <div style="display: flex; width: 100%; justify-content: end;">
            <a href="<?= base_url('admin/user') ?>">
              <button type="button" class="btn btn-danger btn-sm" style="margin-right: 1rem;">Kembali</button>
            </a>
            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content') ?>