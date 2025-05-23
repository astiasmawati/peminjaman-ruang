<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $aksi = $_POST['aksi'];

  if ($aksi === 'pinjam') {
    $ukm = $_POST['ukm'];
    $tanggalMulai = $_POST['tanggalMulai'] ?? null;
    $tanggalSelesai = $_POST['tanggalSelesai'] ?? null;
    $idRuang = $_POST['idRuang'] ?? null;
    $idDosen = $_POST['idDosen'] ?? null;
    $idMhs = $_SESSION['user']['id'] ?? null;

    $stmt = $koneksi->prepare("INSERT INTO peminjaman (ukm, idMhs, idRuang, idDosen, tanggalMulai, tanggalSelesai, status) VALUES (?, ?, ?, ?, ?, ?, 'Menunggu Pembayaran')");
    $stmt->bind_param("siiiss", $ukm, $idMhs, $idRuang, $idDosen, $tanggalMulai, $tanggalSelesai);
    $stmt->execute();

    header('Location: ../peminjaman.php');
    exit;
  } elseif ($aksi == 'bayar') {
    $id = $_POST['id'];
    $namaFile = $_FILES['buktiPembayaran']['name'];
    $tmpFile = $_FILES['buktiPembayaran']['tmp_name'];
    $folderTujuan = '../buktitf/';

    $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
    $namaBaru = $id . '_' . time() . '.' . $ext;
    $pathSimpan = $folderTujuan . $namaBaru;

    if (move_uploaded_file($tmpFile, $pathSimpan)) {
      $pathDB = 'buktitf/' . $namaBaru;
      $stmt = $koneksi->prepare("UPDATE peminjaman SET buktiPembayaran = ?, status = 'Menunggu Validasi' WHERE idPinjam = ?");
      $stmt->bind_param("si", $pathDB, $id);
      $stmt->execute();

      header('Location: ../peminjaman.php');
      exit;
    } else {
      echo "Gagal mengunggah file.";
    }
  } elseif ($aksi == 'hapus') {
    $id = $_POST['id'];
    $result = $koneksi->query("SELECT buktiPembayaran FROM peminjaman WHERE idPinjam = '$id'");
    $row = $result->fetch_assoc();

    if (!empty($row['buktiPembayaran'])) {
      $filePath = '../' . $row['buktiPembayaran'];
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }

    $stmt = $koneksi->prepare("DELETE FROM peminjaman WHERE idPinjam = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: ../peminjaman.php');
    exit;
  } elseif ($aksi == 'update') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $koneksi->prepare("UPDATE peminjaman SET status = ? WHERE idPinjam = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header('Location: ../peminjaman.php');
    exit;
  }
}
