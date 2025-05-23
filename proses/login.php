<?php
session_start();
require '../includes/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

$table = '';
$field = '';
$id = '';

switch ($role) {
  case 'Mahasiswa':
    $table = 'mahasiswa';
    $field = 'npm';
    $id = 'idMhs';
    break;
  case 'Dosen':
    $table = 'dosen';
    $field = 'nip';
    $id = 'idDosen';
    break;
  case 'Tata Usaha':
    $table = 'tu';
    $field = 'username';
    $id = 'idTu';
    break;
  case 'Admin':
    $table = 'admin';
    $field = 'username';
    $id = 'idAdmin';
    break;
  default:
    echo "<script>alert('Role tidak valid.'); window.location.href='../login.php';</script>";
    exit;
}

$query = "SELECT * FROM $table WHERE $field = ? LIMIT 1";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($data = mysqli_fetch_assoc($result)) {
  if (password_verify($password, $data['password'])) {
    $_SESSION['user'] = [
      'id'       => $data[$id],
      'username' => $username,
      'role'     => $role,
      'nama'     => $data['nama']
    ];

    if ($role != "Mahasiswa") {
      header('Location: ../dashboard.php');
    } else {
      header('Location: ../index.php');
    }
    exit;
  } else {
    echo "<script>alert('Password salah.'); window.location.href='../login.php';</script>";
  }
} else {
  echo "<script>alert('User tidak ditemukan.'); window.location.href='../login.php';</script>";
}
