<?php
include "koneksi.php";
session_start();

// Cek login
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit();
}

$id_pengguna = $_SESSION['id'];

// Ambil semua buku yang ada di koleksi pengguna
$query = "
    SELECT data_buku.id_buku, data_buku.judul, data_buku.penulis, data_buku.penerbit, data_buku.tahun, data_buku.foto
    FROM koleksi_pribadi
    JOIN data_buku ON koleksi_pribadi.id_buku = data_buku.id_buku
    WHERE koleksi_pribadi.id_pengguna = '$id_pengguna'
";
$buku = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Koleksi Pribadi</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: #f5f0e6;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 85%;
        margin: 30px auto;
        max-width: 900px;
    }

    h2 {
        text-align: center;
        color: #5a3e36;
        margin-bottom: 15px;
    }

    .message {
        text-align: center;
        color: #5a3e36;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .book-list {
        background: #fff5e6;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .book-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #e6dac8;
    }

    .book-item:last-child {
        border-bottom: none;
    }

    .book-item img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }

    .book-info {
        flex: 1;
    }

    .book-info h3 {
        font-size: 16px;
        margin-bottom: 3px;
        color: #5a3e36;
    }

    .book-info p {
        font-size: 13px;
        color: #7a6f66;
        margin-bottom: 2px;
    }

    .actions {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .actions a {
        text-decoration: none;
        padding: 6px 10px;
        background-color: #c49b6c;
        color: white;
        border-radius: 6px;
        font-size: 13px;
        text-align: center;
        transition: 0.3s;
    }

    .actions a:hover {
        background-color: #a67c52;
    }

    a.back {
        text-decoration: none;
        color: #5a3e36;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }

    .empty {
        text-align: center;
        color: #7a6f66;
        font-style: italic;
        margin-top: 20px;
    }
</style>
</head>
<body>
<div class="container">
    <a href="dashboard_pengguna.php" class="back">← Kembali ke Dashboard</a>
    <h2>Koleksi Pribadi Saya</h2>

    <div class="book-list">
        <?php if (mysqli_num_rows($buku) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($buku)) { ?>
                <div class="book-item">
                    <?php if (!empty($row['foto'])) { ?>
                        <img src="uploads/<?php echo $row['foto']; ?>" alt="<?php echo $row['judul']; ?>">
                    <?php } else { ?>
                        <img src="no-cover.png" alt="No Cover">
                    <?php } ?>
                    <div class="book-info">
                        <h3><?php echo $row['judul']; ?></h3>
                        <p><strong>Penulis:</strong> <?php echo $row['penulis']; ?></p>
                        <p><strong>Penerbit:</strong> <?php echo $row['penerbit']; ?> | <strong>Tahun:</strong> <?php echo $row['tahun']; ?></p>
                    </div>
                    <div class="actions">
                        <a href="peminjaman.php?id_buku=<?php echo $row['id_buku']; ?>">Pinjam</a>
                        <a href="ulasan.php?id_buku=<?php echo $row['id_buku']; ?>">Ulas</a>
                        <a href="booking_buku.php?id_buku=<?= $row['id_buku'] ?>" class="btn">Booking Buku</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="empty">Koleksi Anda masih kosong. Silakan tambahkan buku dari katalog.</p>
        <?php } ?>
    </div>
</div>
</body>
</html>