<?php
include "koneksi.php";

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'terima') {
    $conn->query("UPDATE booking_buku SET status='Diterima' WHERE id_booking='$id'");
    echo "<script>alert('Booking diterima!'); window.location.href='daftar_booking.php';</script>";
} elseif ($aksi == 'tolak') {
    $conn->query("UPDATE booking_buku SET status='Dibatalkan' WHERE id_booking='$id'");
    echo "<script>alert('Booking ditolak!'); window.location.href='daftar_booking.php';</script>";
} else {
    header("Location: daftar_booking.php");
}
?>