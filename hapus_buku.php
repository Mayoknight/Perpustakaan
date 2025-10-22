<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $queryFoto = mysqli_query($conn, "SELECT foto FROM data_buku WHERE id_buku = '$id'");
    $data = mysqli_fetch_assoc($queryFoto);
    if (!empty($data['foto']) && file_exists($data['foto'])) {
        unlink($data['foto']);
    }

    
    $query = "DELETE FROM data_buku WHERE id_buku = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Buku berhasil dihapus!'); window.location='data_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus buku!'); window.location='data_buku.php';</script>";
    }
}
?>