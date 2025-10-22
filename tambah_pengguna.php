<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Admin') {
    header("Location: Home.html");
    exit;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_pengguna'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO pengguna (nama_pengguna, alamat, email, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $alamat, $email, $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil ditambahkan!'); window.location='daftar_pengguna.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pengguna!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Pengguna</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
form {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 400px;
}
input, button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
button {
    background: #007bff;
    color: white;
    border: none;
}
button:hover {
    background: #0056b3;
}
</style>
</head>
<body>
<form method="post">
    <h2>Tambah Pengguna</h2>
    <input type="text" name="nama_pengguna" placeholder="Nama Pengguna" required>
    <input type="text" name="alamat" placeholder="Alamat" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="submit">Tambah</button>
    <a href="daftar_pengguna.php" style="display:block;text-align:center;margin-top:10px;">⬅ Kembali</a>
</form>
</body>
</html>