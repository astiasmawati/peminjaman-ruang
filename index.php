<?php
session_start();

include 'includes/db.php';
include 'includes/functions.php';

$dataRuang = $koneksi->query("SELECT * FROM ruang")->fetch_all(MYSQLI_ASSOC);
$dataDosen = $koneksi->query("SELECT * FROM dosen")->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Peminjaman Ruang</title>

  <!-- CSS FILES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="assets/lp/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/lp/css/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/lp/css/style.css" rel="stylesheet">
</head>

<body>
  <main>
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <span>Peminjaman Ruang</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-lg-auto me-lg-4">
            <li class="nav-item">
              <a class="nav-link click-scroll" href="#section_1">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link click-scroll" href="#section_2">Tentang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link click-scroll" href="#section_3">Daftar Gedung</a>
            </li>
            <li class="nav-item">
              <a class="nav-link click-scroll" href="#section_4">Kontak</a>
            </li>
          </ul>

          <div class="d-none d-lg-block">
            <?php if (isset($_SESSION['user']['id'])): ?>
              <a href="dashboard.php" class="btn custom-btn custom-border-btn btn-naira btn-inverted">
                <i class="btn-icon bi-fire"></i>
                <span>Dashboard</span>
              </a>
            <?php else: ?>
              <a href="login.php" class="btn custom-btn custom-border-btn btn-naira btn-inverted">
                <i class="btn-icon bi-box-arrow-in-right"></i>
                <span>Login</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

    <section class="hero-section d-flex justify-content-center align-items-center vh-100" id="section_1">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-6 col-12 mb-5 pb-5 pb-lg-0 mb-lg-0">
            <h6>UIN RADEN INTAN LAMPUNG</h6>
            <h1 class="text-white mb-4">Peminjaman Gedung dengan mudah</h1>
            <a href="#section_2" class="btn custom-btn smoothscroll me-3">Tentang Kami</a>
          </div>

          <div class="hero-image-wrap col-lg-6 col-12 mt-3 mt-lg-0">
            <div class="card">
              <div class="card-body">
                <div class="fs-4 text-dark">Pinjam Disini</div>
                <div class="text-disabled mb-4 fw-light" style="font-size: 12px;">Login terlebih dahulu</div>
                <form method="post" action="proses/pinjam.php">
                  <input type="hidden" name="aksi" value="pinjam">
                  <div class="mb-3">
                    <select class="form-select" name="ukm" required>
                      <option disabled selected>Pilih UKM</option>
                      <option value="Bahasa">Bahasa</option>
                      <option value="Blitz">Blitz</option>
                      <option value="Pers">Pers</option>
                      <option value="FORMAKIP">FORMAKIP</option>
                      <option value="Taekwondo">Taekwondo</option>
                      <option value="Bapinda">Bapinda</option>
                      <option value="Probotik">Probotik</option>
                      <option value="Himasi">Himasi</option>
                      <option value="HMJ PAI">HMJ PAI</option>
                      <option value="Himapbio">Himapbio</option>
                      <option value="HMJ PBA">HMJ PBA</option>
                      <option value="HimaBio">HimaBio</option>
                    </select>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label for="tanggalMulai">Tanggal Mulai</label>
                      <input type="date" id="tanggalMulai" name="tanggalMulai" class="form-control" required>
                    </div>
                    <div class="col">
                      <label for="tanggalSelesai">Tanggal Selesai</label>
                      <input type="date" id="tanggalSelesai" name="tanggalSelesai" class="form-control" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <select class="form-select" name="idRuang" required>
                        <option disabled selected>Pilih Ruangan</option>
                        <?php foreach ($dataRuang as $ruang): ?>
                          <option value="<?= $ruang['idRuang'] ?>" data-tarif="<?= $ruang['tarif'] ?>"><?= htmlspecialchars($ruang['nama']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="col">
                      <select class="form-select" name="idDosen" required>
                        <option disabled selected>Pilih Dosen</option>
                        <?php foreach ($dataDosen as $dosen): ?>
                          <option value="<?= $dosen['idDosen'] ?>"><?= htmlspecialchars($dosen['nama']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <!-- <button type="button" id="btnPreview" class="btn custom-primary-btn w-100">Lanjutkan</button> -->
                  <button type="submit" class="btn custom-primary-btn w-100">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>

    <section class="book-section section-padding" id="section_2">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-12">
            <img src="assets/lp/images/SBSN.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 col-12">
            <div class="book-section-info">
              <h6>Universitas Islam Negeri</h6>
              <h2 class="mb-4">UIN RADEN INTAN LAMPUNG</h2>
              <p>Universitas Islam Negeri (UIN) Raden Intan Lampung merupakan Perguruan Tinggi Keagamaan Islam tertua dan terbesar di Lampung</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="section-padding" id="section_3">
      <div class="container py-5">
        <h1 class="text-center mb-5">Daftar Gedung</h1>
        <div class="py-lg-2"></div>
        <div class="row mt-5 px-5">
          <?php foreach ($dataRuang as $ruang): ?>
            <div class="md:col-3 col-6 mb-3 text-center">
              <?= $ruang['nama'] ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="contact-section section-padding" id="section_4">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-12 mx-auto">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d63555.51157587272!2d105.303645!3d-5.383478!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db5b76061255%3A0xda8d0dd733511d75!2sUIN%20Raden%20Intan%20Lampung!5e0!3m2!1sen!2sus!4v1747473745165!5m2!1sen!2sus" width="500" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="col-lg-6 col-12">
            <h2 class="mb-4">Kontak Kami</h2>
            <p class="mb-3">
              <i class="bi-geo-alt me-2"></i>
              Jl. Letnan Kolonel H. Endro Suratmin, Sukarame, Kota Bandar Lampung, 35131
            </p>
            <p class="mb-2">
              <a href="tel: +62 721 780887 " class="contact-link">+62 721 780887</a>
            </p>
            <p>
              <a href="mailto:humas@radenintan.ac.id" class="contact-link">humas@radenintan.ac.id</a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal -->
  <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Konfirmasi Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Silakan transfer biaya peminjaman ke rekening berikut:</p>
          <ul>
            <li><strong>Bank:</strong> BNI</li>
            <li><strong>No Rekening:</strong> 1234567890</li>
            <li><strong>Atas Nama:</strong> UIN Raden Intan</li>
          </ul>
          <p><strong>Tarif:</strong> <span id="modalTarif">Rp 0</span></p>
          <div class="mb-3">
            <label for="buktiPembayaran" class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" class="form-control" name="buktiPembayaran" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Kirim Peminjaman</button>
        </div>
      </div>
    </div>
  </div>
  <!-- JAVASCRIPT FILES -->
  <script src="assets/lp/js/jquery.min.js"></script>
  <script src="assets/lp/js/bootstrap.bundle.min.js"></script>
  <script src="assets/lp/js/jquery.sticky.js"></script>
  <script src="assets/lp/js/click-scroll.js"></script>
  <script src="assets/lp/js/custom.js"></script>
  <!-- <script>
    document.getElementById("btnPreview").addEventListener("click", function() {
      const ruangSelect = document.querySelector('select[name="idRuang"]');
      const selectedOption = ruangSelect.options[ruangSelect.selectedIndex];

      const tarif = selectedOption.getAttribute('data-tarif') || 0;
      const modalTarif = document.getElementById("modalTarif");

      modalTarif.innerText = "Rp " + parseInt(tarif).toLocaleString("id-ID");

      const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
      modal.show();
    });
  </script> -->

</body>

</html>