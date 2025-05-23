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
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($username && $nama && $password) {
      $stmt = $koneksi->prepare("INSERT INTO tu (username, nama, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $username, $nama, password_hash($password, PASSWORD_DEFAULT));
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/tu.php");
    exit();
  } elseif ($aksi === 'update') {
    $id       = (int) $_POST['id'];
    $username = trim($_POST['username']);
    $nama     = trim($_POST['nama']);
    $password = trim($_POST['password']);

    if ($id && $username && $nama) {
      if ($password != "") {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("UPDATE tu SET username = ?, nama = ?, password = ? WHERE idTu = ?");
        $stmt->bind_param("sssi", $username, $nama, $password, $id);
      } else {
        $stmt = $koneksi->prepare("UPDATE tu SET username = ?, nama = ? WHERE idTu = ?");
        $stmt->bind_param("ssi", $username, $nama, $id);
      }
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/tu.php");
    exit();
  } elseif ($aksi === 'delete') {
    $id = (int) $_POST['id'];

    if ($id) {
      $stmt = $koneksi->prepare("DELETE FROM tu WHERE idTu = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->close();
    }

    header("Location: ../admin/tu.php");
    exit();
  }
}
