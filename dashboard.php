<?php
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/functions.php';

$idUser = $_SESSION['user']['id'];

$totalRuangan = $koneksi->query("SELECT COUNT(*) as total FROM ruang")->fetch_assoc()['total'];
$totalDosen = $totalTU = $totalMahasiswa = $totalPeminjaman = 0;
$recentPeminjaman = [];

if (checkRole(['Tata Usaha', 'Admin'])) {
  $totalDosen = $koneksi->query("SELECT COUNT(*) as total FROM dosen")->fetch_assoc()['total'];
  $totalTU = $koneksi->query("SELECT COUNT(*) as total FROM tu")->fetch_assoc()['total'];
  $totalMahasiswa = $koneksi->query("SELECT COUNT(*) as total FROM mahasiswa")->fetch_assoc()['total'];
  $totalPeminjaman = $koneksi->query("SELECT COUNT(*) as total FROM peminjaman")->fetch_assoc()['total'];
  $recentPeminjaman = $koneksi->query("SELECT p.*, m.nama AS namaMhs, m.npm, d.nama AS namaDosen, d.nip, r.nama AS namaRuang, r.tarif FROM peminjaman p JOIN mahasiswa m ON p.idMhs = m.idMhs JOIN dosen d ON p.idDosen = d.idDosen JOIN ruang r ON p.idRuang = r.idRuang ORDER BY idPinjam DESC LIMIT 5");
} elseif (checkRole('Dosen')) {
  $totalMahasiswa = $koneksi->query("SELECT COUNT(*) as total FROM mahasiswa")->fetch_assoc()['total'];
  $totalPeminjaman = $koneksi->query("SELECT COUNT(*) as total FROM peminjaman WHERE idDosen = $idUser")->fetch_assoc()['total'];
  $recentPeminjaman = $koneksi->query("SELECT p.*, m.nama AS namaMhs, m.npm, r.nama AS namaRuang, r.tarif FROM peminjaman p JOIN mahasiswa m ON p.idMhs = m.idMhs JOIN ruang r ON p.idRuang = r.idRuang WHERE p.idDosen = $idUser ORDER BY idPinjam DESC LIMIT 5");
} elseif (checkRole('Mahasiswa')) {
  $totalMahasiswa = $koneksi->query("SELECT COUNT(*) as total FROM mahasiswa")->fetch_assoc()['total'];
  $totalPeminjaman = $koneksi->query("SELECT COUNT(*) as total FROM peminjaman WHERE idMhs = $idUser")->fetch_assoc()['total'];
  $recentPeminjaman = $koneksi->query("SELECT p.*, d.nama AS namaDosen, d.nip, r.nama AS namaRuang, r.tarif FROM peminjaman p JOIN dosen d ON p.idDosen = d.idDosen JOIN ruang r ON p.idRuang = r.idRuang WHERE p.idMhs = $idUser ORDER BY idPinjam DESC LIMIT 5");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
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
            <h1>Dashboard</h1>
          </div>

          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info"><i class="fas fa-door-closed"></i></div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Ruangan</h4>
                  </div>
                  <div class="card-body"><?= $totalRuangan ?></div>
                </div>
              </div>
            </div>
            <?php if (checkRole(['Tata Usaha', 'Admin'])): ?>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary"><i class="fas fa-user-tie"></i></div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Dosen</h4>
                    </div>
                    <div class="card-body"><?= $totalDosen ?></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-dark"><i class="fas fa-user-shield"></i></div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total TU</h4>
                    </div>
                    <div class="card-body"><?= $totalTU ?></div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning"><i class="fas fa-user-graduate"></i></div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Mahasiswa</h4>
                  </div>
                  <div class="card-body"><?= $totalMahasiswa ?></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success"><i class="fas fa-calendar-check"></i></div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Peminjaman</h4>
                  </div>
                  <div class="card-body"><?= $totalPeminjaman ?></div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">5 Peminjaman Terakhir</h2>
            <p class="section-lead"><a href="<?= base_url('peminjaman.php') ?>">Data Peminjaman</a></p>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>UKM</th>
                    <?php if (!checkRole('Mahasiswa')): ?>
                    <th>MAHASISWA</th>
                    <?php endif ?>
                    <?php if (!checkRole('Dosen')): ?>
                    <th>DOSEN</th>
                    <?php endif ?>
                    <th>RUANGAN</th>
                    <th>TANGGAL MULAI</th>
                    <th>TANGGAL SELESAI</th>
                    <th>STATUS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($recentPeminjaman as $d): ?>
                    <tr>
                      <td><?= $d['ukm'] ?></td>
                      <?php if (!checkRole('Mahasiswa')): ?>
                      <td><?= $d['namaMhs'] ?> (<?= $d['npm'] ?>)</td>
                      <?php endif ?>
                      <?php if (!checkRole('Dosen')): ?>
                      <td><?= $d['namaDosen'] ?> (<?= $d['nip'] ?>)</td>
                      <?php endif ?>
                      <td><?= $d['namaRuang'] ?></td>
                      <td><?= $d['tanggalMulai'] ?></td>
                      <td><?= $d['tanggalSelesai'] ?></td>
                      <td><?= $d['status'] ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>

        </section>
      </div>
    </div>
  </div>

  <?php include 'includes/scripts.php'; ?>
</body>

</html>