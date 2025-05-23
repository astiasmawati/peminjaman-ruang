<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/auth.php';

if (!checkRole('Admin')) {
  header('Location: ../admin/ruang.php');
  exit;
}

$aksi = $_POST['aksi'] ?? '';
$id = $_POST['id'] ?? null;
$nama = $_POST['nama'] ?? '';
$tarif = $_POST['tarif'] ?? 0;

switch ($aksi) {
  case 'tambah':
    $stmt = $koneksi->prepare("INSERT INTO ruang (nama, tarif) VALUES (?, ?)");
    $stmt->bind_param("si", $nama, $tarif);
    $stmt->execute();
    break;

  case 'update':
    $stmt = $koneksi->prepare("UPDATE ruang SET nama = ?, tarif = ? WHERE idRuang = ?");
    $stmt->bind_param("sii", $nama, $tarif, $id);
    $stmt->execute();
    break;

  case 'delete':
    $stmt = $koneksi->prepare("DELETE FROM ruang WHERE idRuang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    break;
}

header('Location: ../admin/ruang.php');
exit;
