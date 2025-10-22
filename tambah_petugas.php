<?php
include 'koneksi.php';
session_start();

// Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    header("Location: Login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO petugas (nama_petugas, username, password, level, alamat)
              VALUES ('$nama_petugas', '$username', '$password', '$level', '$alamat')";
    mysqli_query($koneksi, $query);
    header("Location: daftar_petugas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Petugas</title>
    <style>
        body { font-family: Arial; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 8px; }
        button { background: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 8px; cursor: pointer; width: 100%; }
        button:hover { background: #45a049; }
        a { text-decoration: none; color: #555; display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Tambah Petugas</h2>
        <input type="text" name="nama_petugas" placeholder="Nama Petugas" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="level" required>
            <option value="">-- Pilih Level --</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
        <textarea name="alamat" placeholder="Alamat" required></textarea>
        <button type="submit" name="submit">Tambah</button>
        <a href="daftar_petugas.php">← Kembali</a>
    </form>
</body>
</html>