<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';

if (!checkRole('Admin')) {
  header('Location: dashboard.php');
  exit;
}

$dataTU = $koneksi->query("SELECT * FROM tu")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Tata Usaha</title>

  <?php include '../includes/head.php'; ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include '../includes/nav.php'; ?>
      <?php include '../includes/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Data Tata Usaha</h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Data</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dataTU as $i => $tu): ?>
                            <tr>
                              <th class="text-center"><?= $i + 1 ?></th>
                              <td><?= htmlspecialchars($tu['username']) ?></td>
                              <td><?= htmlspecialchars($tu['nama']) ?></td>
                              <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $tu['idTu'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?= $tu['idTu'] ?>">Hapus</button>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form method="post" action="<?= base_url('proses/tu.php') ?>">
        <input type="hidden" name="aksi" value="tambah">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah TU</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php foreach ($dataTU as $tu): ?>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $tu['idTu'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/tu.php') ?>">
          <input type="hidden" name="aksi" value="update">
          <input type="hidden" name="id" value="<?= $tu['idTu'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit TU</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($tu['username']) ?>" required>
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($tu['nama']) ?>" required>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongi jika tidak ingin update password">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete<?= $tu['idTu'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/tu.php') ?>">
          <input type="hidden" name="aksi" value="delete">
          <input type="hidden" name="id" value="<?= $tu['idTu'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus TU</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              Yakin ingin menghapus TU <strong><?= htmlspecialchars($tu['nama']) ?></strong>?
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Hapus</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>

  <?php include '../includes/scripts.php'; ?>
</body>

</html>