<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';

if (!checkRole('Admin')) {
  header('Location: dashboard.php');
  exit;
}

$dataMahasiswa = $koneksi->query("SELECT * FROM mahasiswa")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Mahasiswa</title>
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
            <h1>Data Mahasiswa</h1>
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
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dataMahasiswa as $i => $mahasiswa): ?>
                            <tr>
                              <th class="text-center"><?= $i + 1 ?></th>
                              <td><?= $mahasiswa['npm'] ?></td>
                              <td><?= $mahasiswa['nama'] ?></td>
                              <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $mahasiswa['idMhs'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?= $mahasiswa['idMhs'] ?>">Hapus</button>
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
      <form method="post" action="<?= base_url('proses/mahasiswa.php') ?>">
        <input type="hidden" name="aksi" value="tambah">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>NPM</label>
              <input type="text" name="npm" class="form-control" required>
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

  <?php foreach ($dataMahasiswa as $mahasiswa): ?>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $mahasiswa['idMhs'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/mahasiswa.php') ?>">
          <input type="hidden" name="aksi" value="update">
          <input type="hidden" name="id" value="<?= $mahasiswa['idMhs'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Mahasiswa</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" value="<?= htmlspecialchars($mahasiswa['npm']) ?>" required>
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($mahasiswa['nama']) ?>" required>
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
    <div class="modal fade" id="modalDelete<?= $mahasiswa['idMhs'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/mahasiswa.php') ?>">
          <input type="hidden" name="aksi" value="delete">
          <input type="hidden" name="id" value="<?= $mahasiswa['idMhs'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Mahasiswa</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              Yakin ingin menghapus mahasiswa <strong><?= htmlspecialchars($mahasiswa['nama']) ?></strong>?
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