<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/functions.php';

if (!checkRole('Admin')) {
  header('Location: dashboard.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $aksi = $_POST['aksi'];

  if ($aksi === 'tambah') {
    $nip = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($nip && $nama && $password) {
      $stmt = $koneksi->prepare("INSERT INTO dosen (nip, nama, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nip, $nama, password_hash($password, PASSWORD_DEFAULT));
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/dosen.php");
    exit();
  } elseif ($aksi === 'update') {
    $id   = (int) $_POST['id'];
    $nip  = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($id && $nip && $nama) {
      if ($password != "") {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("UPDATE dosen SET nip = ?, nama = ?, password = ? WHERE idDosen = ?");
        $stmt->bind_param("sssi", $nip, $nama, $password, $id);
      } else {
        $stmt = $koneksi->prepare("UPDATE dosen SET nip = ?, nama = ? WHERE idDosen = ?");
        $stmt->bind_param("ssi", $nip, $nama, $id);
      }
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/dosen.php");
    exit();
  } elseif ($aksi === 'delete') {
    $id = (int) $_POST['id'];

    if ($id) {
      $stmt = $koneksi->prepare("DELETE FROM dosen WHERE idDosen = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/dosen.php");
    exit();
  }
}
