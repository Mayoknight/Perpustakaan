<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['Admin', 'Staff'])) {
    header("Location: Home.html");
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM rak WHERE id_rak=$id");
header("Location: data_rak.php");
exit;
?>