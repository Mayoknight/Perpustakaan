<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['Admin', 'Staff'])) {
    header("Location: Home.html");
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM kategori WHERE id_kategori=$id");
header("Location: data_kategori.php");
exit;
?>