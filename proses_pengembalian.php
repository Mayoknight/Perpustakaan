<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit();
}

$id_pengguna = $_SESSION['id'];

if (isset($_POST['kembalikan'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_pengguna = $_SESSION['id'];

    $ambil = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id='$id_peminjaman' AND id_pengguna='$id_pengguna'");
    $data_buku = mysqli_fetch_array($ambil);

    if ($data_buku) {
        // Ambil id_petugas dari peminjaman
        $id_petugas = $data_buku['id_petugas'];

        // Masukkan ke pengembalian
        $insert = mysqli_query($koneksi, "
            INSERT INTO pengembalian (id_peminjaman, id_petugas, id_pengguna, tanggal_kembali, denda)
            VALUES ('$id_peminjaman', '$id_petugas', '$id_pengguna', NOW(), 0)
        ");

        // Hapus dari tabel peminjaman
        if ($insert) {
            mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id='$id_peminjaman'");
            header("Location: pengembalian.php?status=sukses");
            exit;
        } else {
            header("Location: pengembalian.php?status=gagal");
            exit;
        }
    } else {
        header("Location: pengembalian.php?status=gagal");
        exit;
    }
}
?>