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
    $npm = trim($_POST['npm']);
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($npm && $nama && $password) {
      $stmt = $koneksi->prepare("INSERT INTO mahasiswa (npm, nama, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $npm, $nama, password_hash($password, PASSWORD_DEFAULT));
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/mahasiswa.php");
    exit();
  } elseif ($aksi === 'update') {
    $id   = (int) $_POST['id'];
    $npm  = trim($_POST['npm']);
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($id && $npm && $nama) {
      if ($password != "") {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("UPDATE mahasiswa SET npm = ?, nama = ?, password = ? WHERE idMhs = ?");
        $stmt->bind_param("sssi", $npm, $nama, $password, $id);
      } else {
        $stmt = $koneksi->prepare("UPDATE mahasiswa SET npm = ?, nama = ? WHERE idMhs = ?");
        $stmt->bind_param("ssi", $npm, $nama, $id);
      }
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/mahasiswa.php");
    exit();
  } elseif ($aksi === 'delete') {
    $id = (int) $_POST['id'];

    if ($id) {
      $stmt = $koneksi->prepare("DELETE FROM mahasiswa WHERE idMhs = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/mahasiswa.php");
    exit();
  }
}
