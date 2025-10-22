<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['Admin', 'Staff'])) {
    header("Location: Home.html");
    exit;
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM rak WHERE id_rak=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_rak'];
    $conn->query("UPDATE rak SET nama_rak='$nama' WHERE id_rak=$id");
    header("Location: data_rak.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Rak</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.form-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 30px 40px;
    width: 400px;
    text-align: center;
}
h2 { color: #333; margin-bottom: 20px; }
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}
button, a {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
}
button:hover, a:hover {
    opacity: 0.9;
}
a { background: #28a745; }
</style>
</head>
<body>
<div class="form-container">
    <h2>Edit Rak</h2>
    <form method="POST">
        <input type="text" name="nama_rak" value="<?= htmlspecialchars($data['nama_rak']) ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="data_rak.php">⬅ Kembali</a>
</div>
</body>
</html>