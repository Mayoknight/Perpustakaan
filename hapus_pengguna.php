<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Admin') {
    header("Location: Home.html");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM pengguna WHERE id_pengguna=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Pengguna berhasil dihapus!'); window.location='daftar_pengguna.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus pengguna!'); window.location='daftar_pengguna.php';</script>";
}
?>