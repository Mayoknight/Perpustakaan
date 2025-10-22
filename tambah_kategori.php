<?php
session_start();
include 'koneksi.php';

// Cek login dan akses
if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['Admin', 'Staff'])) {
    header("Location: Home.html");
    exit;
}

// Jika form disubmit
if (isset($_POST['submit'])) {
    $nama_kategori = trim($_POST['nama_kategori']);

    if (!empty($nama_kategori)) {
        $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param("s", $nama_kategori);
        $stmt->execute();
        $stmt->close();

        header("Location: data_kategori.php");
        exit;
    } else {
        $error = "Nama kategori tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Kategori</title>
<link rel="stylesheet" href="../style.css">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
    margin: 0;
}
.container {
    width: 400px;
    margin: 60px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 25px;
}
h2 {
    text-align: center;
    color: #333;
}
form {
    display: flex;
    flex-direction: column;
}
input[type="text"] {
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}
button {
    background: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
button:hover {
    opacity: 0.9;
}
.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
a {
    display: inline-block;
    text-align: center;
    text-decoration: none;
    background: #6c757d;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    margin-top: 10px;
}
</style>
</head>
<body>
<div class="container">
    <h2>Tambah Kategori</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="nama_kategori">Nama Kategori:</label>
        <input type="text" id="nama_kategori" name="nama_kategori" required>
        <button type="submit" name="submit">Simpan</button>
    </form>
    <a href="data_kategori.php">⬅ Kembali</a>
</div>
</body>
</html>