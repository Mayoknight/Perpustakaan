<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Admin') {
    header("Location: Home.html");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pengguna WHERE id_pengguna = '$id'");
$row = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_pengguna'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE pengguna SET nama_pengguna=?, alamat=?, email=?, username=?, password=? WHERE id_pengguna=?");
        $stmt->bind_param("sssssi", $nama, $alamat, $email, $username, $password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE pengguna SET nama_pengguna=?, alamat=?, email=?, username=? WHERE id_pengguna=?");
        $stmt->bind_param("ssssi", $nama, $alamat, $email, $username, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='daftar_pengguna.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pengguna</title>
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
    background: #28a745;
    color: white;
    border: none;
}
button:hover {
    background: #218838;
}
</style>
</head>
<body>
<form method="post">
    <h2>Edit Pengguna</h2>
    <input type="text" name="nama_pengguna" value="<?= $row['nama_pengguna'] ?>" required>
    <input type="text" name="alamat" value="<?= $row['alamat'] ?>" required>
    <input type="email" name="email" value="<?= $row['email'] ?>" required>
    <input type="text" name="username" value="<?= $row['username'] ?>" required>
    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
    <button type="submit" name="submit">Simpan</button>
    <a href="daftar_pengguna.php" style="display:block;text-align:center;margin-top:10px;">⬅ Kembali</a>
</form>
</body>
</html>