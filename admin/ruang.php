<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';

if (!checkRole('Admin')) {
  header('Location: dashboard.php');
  exit;
}

$dataRuang = $koneksi->query("SELECT * FROM ruang")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Ruang</title>
  <?php include '../includes/head.php'; ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include '../includes/nav.php'; ?>
      <?php include '../includes/sidebar.php'; ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Data Ruang</h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Ruang</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tarif</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dataRuang as $i => $ruang): ?>
                            <tr>
                              <td><?= $i + 1 ?></td>
                              <td><?= htmlspecialchars($ruang['nama']) ?></td>
                              <td>Rp<?= number_format($ruang['tarif'], 0, ',', '.') ?></td>
                              <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $ruang['idRuang'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?= $ruang['idRuang'] ?>">Hapus</button>
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
      <form method="post" action="<?= base_url('proses/ruang.php') ?>">
        <input type="hidden" name="aksi" value="tambah">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Ruang</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Tarif</label>
              <input type="number" name="tarif" class="form-control" required>
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

  <?php foreach ($dataRuang as $ruang): ?>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit<?= $ruang['idRuang'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/ruang.php') ?>">
          <input type="hidden" name="aksi" value="update">
          <input type="hidden" name="id" value="<?= $ruang['idRuang'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Ruang</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($ruang['nama']) ?>" required>
              </div>
              <div class="form-group">
                <label>Tarif</label>
                <input type="number" name="tarif" class="form-control" value="<?= $ruang['tarif'] ?>" required>
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
    <div class="modal fade" id="modalDelete<?= $ruang['idRuang'] ?>" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('proses/ruang.php') ?>">
          <input type="hidden" name="aksi" value="delete">
          <input type="hidden" name="id" value="<?= $ruang['idRuang'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Ruang</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              Yakin ingin menghapus ruang <strong><?= htmlspecialchars($ruang['nama']) ?></strong>?
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
