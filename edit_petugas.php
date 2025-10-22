<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Admin') {
    header("Location: Home.html");
    exit;
}

$id_petugas = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "UPDATE petugas SET 
        nama_petugas='$nama_petugas', 
        username='$username', 
        password='$password', 
        level='$level',
        alamat='$alamat'
        WHERE id_petugas='$id_petugas'");
    
    header("Location: daftar_petugas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Petugas</title>
    <style>
        body { font-family: Arial; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 8px; }
        button { background: #2196F3; color: white; padding: 10px 15px; border: none; border-radius: 8px; cursor: pointer; width: 100%; }
        button:hover { background: #1976D2; }
        a { text-decoration: none; color: #555; display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Edit Petugas</h2>
        <input type="text" name="nama_petugas" value="<?= $data['nama_petugas'] ?>" required>
        <input type="text" name="username" value="<?= $data['username'] ?>" required>
        <input type="password" name="password" value="<?= $data['password'] ?>" required>
        <select name="level" required>
            <option value="admin" <?= $data['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="staff" <?= $data['level'] == 'staff' ? 'selected' : '' ?>>Staff</option>
        </select>
        <textarea name="alamat" required><?= $data['alamat'] ?></textarea>
        <button type="submit" name="submit">Simpan Perubahan</button>
        <a href="daftar_petugas.php">← Kembali</a>
    </form>
</body>
</html>