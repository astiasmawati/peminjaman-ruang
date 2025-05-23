<?php
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/functions.php';

if (checkRole('Mahasiswa')) {
  $idMhs = $_SESSION['user']['id'];
  $data = $koneksi->query("
    SELECT 
      p.*, 
      m.nama AS namaMhs, m.npm,
      d.nama AS namaDosen, d.nip,
      r.nama AS namaRuang, r.tarif
    FROM peminjaman p
    JOIN mahasiswa m ON p.idMhs = m.idMhs
    JOIN dosen d ON p.idDosen = d.idDosen
    JOIN ruang r ON p.idRuang = r.idRuang
    WHERE p.idMhs = '$idMhs'
    ORDER BY p.idPinjam DESC
  ")->fetch_all(MYSQLI_ASSOC);
} elseif (checkRole('Dosen')) {
  $idDosen = $_SESSION['user']['id'];
  $data = $koneksi->query("
    SELECT 
      p.*, 
      m.nama AS namaMhs, m.npm,
      d.nama AS namaDosen, d.nip,
      r.nama AS namaRuang, r.tarif
    FROM peminjaman p
    JOIN mahasiswa m ON p.idMhs = m.idMhs
    JOIN dosen d ON p.idDosen = d.idDosen
    JOIN ruang r ON p.idRuang = r.idRuang
    WHERE p.idDosen = '$idDosen'
    ORDER BY p.idPinjam DESC
  ")->fetch_all(MYSQLI_ASSOC);
} elseif (checkRole(['Tata Usaha', 'Admin'])) {
  $data = $koneksi->query("
    SELECT 
      p.*, 
      m.nama AS namaMhs, m.npm,
      d.nama AS namaDosen, d.nip,
      r.nama AS namaRuang, r.tarif
    FROM peminjaman p
    JOIN mahasiswa m ON p.idMhs = m.idMhs
    JOIN dosen d ON p.idDosen = d.idDosen
    JOIN ruang r ON p.idRuang = r.idRuang
    ORDER BY p.idPinjam DESC
  ")->fetch_all(MYSQLI_ASSOC);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Peminjaman</title>
  <?php include 'includes/head.php'; ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include 'includes/nav.php'; ?>
      <?php include 'includes/sidebar.php'; ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Data Peminjaman</h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>UKM</th>
                            <th>MAHASISWA</th>
                            <th>DOSEN</th>
                            <th>RUANGAN</th>
                            <th>TANGGAL MULAI</th>
                            <th>TANGGAL SELESAI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($data as $d): ?>
                            <tr>
                              <td><?= $d['ukm'] ?></td>
                              <td><?= $d['namaMhs'] ?> (<?= $d['npm'] ?>)</td>
                              <td><?= $d['namaDosen'] ?> (<?= $d['nip'] ?>)</td>
                              <td><?= $d['namaRuang'] ?></td>
                              <td><?= $d['tanggalMulai'] ?></td>
                              <td><?= $d['tanggalSelesai'] ?></td>
                              <td><?= $d['status'] ?></td>
                              <td>
                                <?php if (checkRole('Mahasiswa') && empty($d['buktiPembayaran'])): ?>
                                  <button class="btn btn-info" data-toggle="modal" data-target="#modalBayar<?= $d['idPinjam'] ?>">Bayar</button>
                                <?php else: ?>
                                  <button class="btn btn-warning" data-toggle="modal" data-target="#modalDetail<?= $d['idPinjam'] ?>">Detail</button>
                                <?php endif ?>

                                <?php if (checkRole('Admin')): ?>
                                  <button class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?= $d['idPinjam'] ?>">Hapus</button>
                                <?php endif ?>
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

  <?php foreach ($data as $d): ?>
    <?php if (checkRole('Mahasiswa') && empty($d['buktiPembayaran'])): ?>
      <div class="modal fade" id="modalBayar<?= $d['idPinjam'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <form method="post" action="<?= base_url('proses/pinjam.php') ?>" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="bayar">
            <input type="hidden" name="id" value="<?= $d['idPinjam'] ?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Bayar Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>Silakan transfer biaya peminjaman ke rekening berikut:</p>
                <ul>
                  <li><strong>Bank:</strong> BNI</li>
                  <li><strong>No Rekening:</strong> 1234567890</li>
                  <li><strong>Atas Nama:</strong> UIN Raden Intan</li>
                </ul>
                <p><strong>Tarif:</strong> Rp<?= number_format($d['tarif'], 0, ',', '.') ?></p>

                <div class="form-group">
                  <label>Bukti Pembayaran</label>
                  <input type="file" name="buktiPembayaran" class="form-control" required>
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
    <?php else: ?>
      <div class="modal fade" id="modalDetail<?= $d['idPinjam'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <form method="post" action="<?= base_url('proses/pinjam.php') ?>">
            <input type="hidden" name="aksi" value="update">
            <input type="hidden" name="id" value="<?= $d['idPinjam'] ?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Update Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p><strong>Tarif:</strong> Rp<?= number_format($d['tarif'], 0, ',', '.') ?></p>
                <?php if (!checkRole('Mahasiswa')): ?>
                  <div class="mb-3">
                    <label for="status"><strong>Status:</strong></label>
                    <select name="status" id="status" class="form-control">
                      <option value="Menunggu Pembayaran" <?= $d['status'] == 'Menunggu Pembayaran' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                      <option value="Menunggu Validasi" <?= $d['status'] == 'Menunggu Validasi' ? 'selected' : '' ?>>Menunggu Validasi</option>
                      <option value="Ditolak Dosen" <?= $d['status'] == 'Ditolak Dosen' ? 'selected' : '' ?>>Ditolak Dosen</option>
                      <option value="Ditolak TU" <?= $d['status'] == 'Ditolak TU' ? 'selected' : '' ?>>Ditolak TU</option>
                      <option value="Disetujui" <?= $d['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                      <option value="Selesai" <?= $d['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                  </div>
                <?php endif ?>
                <p><strong>Bukti Pembayaran:</strong></p>
                <img src="<?= base_url($d['buktiPembayaran']) ?>" class="img-fluid">
              </div>
              <div class="modal-footer">
                <?php if (!checkRole('Mahasiswa')): ?>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                <?php endif ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endif ?>
    <?php if (checkRole('Admin')): ?>
      <!-- Modal Delete -->
      <div class="modal fade" id="modalDelete<?= $d['idPinjam'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <form method="post" action="<?= base_url('proses/pinjam.php') ?>">
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id" value="<?= $d['idPinjam'] ?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Hapus Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                Yakin ingin menghapus?
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endif ?>
  <?php endforeach; ?>
  <?php include 'includes/scripts.php'; ?>
</body>

</html>