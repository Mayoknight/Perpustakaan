<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['Admin', 'Staff'])) {
    header("Location: Home.html");
    exit;
}

$result = $conn->query("SELECT * FROM kategori ORDER BY id_kategori DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Kategori</title>
<style>
body{font-family:'Poppins',sans-serif;background:#f4f6f9;margin:0;padding:0;}
.container{width:85%;margin:40px auto;background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);padding:25px;}
h2{text-align:center;color:#333;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#007bff;color:#fff;}
tr:hover{background-color:#f1f1f1;}
a.btn{display:inline-block;padding:8px 14px;margin:3px;background:#007bff;color:white;text-decoration:none;border-radius:6px;}
a.btn-danger{background:#dc3545;}
a.btn-edit{background:#ffc107;color:black;}
a.btn:hover{opacity:0.9;}
</style>
</head>
<body>
<div class="container">
    <h2>Daftar Kategori</h2>
    <a href="tambah_kategori.php" class="btn">+ Tambah Kategori</a>
    <table>
        <tr><th>ID</th><th>Nama Kategori</th><th>Aksi</th></tr>
        <?php while($row=$result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_kategori'] ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td>
                <a href="edit_kategori.php?id=<?= $row['id_kategori'] ?>" class="btn btn-edit">Edit</a>
                <a href="hapus_kategori.php?id=<?= $row['id_kategori'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="<?= $_SESSION['level']=='Admin'?'dashboard_admin.php':'dashboard_staff.php' ?>" class="back">← Kembali ke Dashboard</a>
</div>
</body>
</html>
