<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    header("Location: Home.html");
    exit;
}

$id_petugas = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas = '$id_petugas'");
header("Location: daftar_petugas.php");
exit;
?>