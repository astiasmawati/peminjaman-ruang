<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';

if (!checkRole('Admin')) {
  header('Location: dashboard.php');
  exit;
}

$dataDosen = $koneksi->query("SELECT * FROM dosen")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Dosen</title>

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
            <h1>Data Dosen</h1>
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
                            <th class="text-center">
                              #
                            </th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>AKSI</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dataDosen as $i => $dosen): ?>
                            <tr>
                              <th class="text-center">
                                <?= $i + 1 ?>
                              </th>
                              <td><?= $dosen['nip'] ?></td>
                              <td><?= $dosen['nama'] ?></td>
                              <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $dosen['idDosen'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?= $dosen['idDosen'] ?>">Hapus</button>
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
      <form method="post" action="<?= base_url('proses/dosen.php') ?>">
        <input type="hidden" name="aksi" value="tambah">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Dosen</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>NIP</label>
              <input type="text" name="nip" class="form-control" required>
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

  <?php foreach ($dataDosen as $dosen): ?>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $dosen['idDosen'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/dosen.php') ?>">
          <input type="hidden" name="aksi" value="update">
          <input type="hidden" name="id" value="<?= $dosen['idDosen'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Dosen</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control" value="<?= htmlspecialchars($dosen['nip']) ?>" required>
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($dosen['nama']) ?>" required>
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
    <div class="modal fade" id="modalDelete<?= $dosen['idDosen'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/dosen.php') ?>">
          <input type="hidden" name="aksi" value="delete">
          <input type="hidden" name="id" value="<?= $dosen['idDosen'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Dosen</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              Yakin ingin menghapus dosen <strong><?= htmlspecialchars($dosen['nama']) ?></strong>?
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