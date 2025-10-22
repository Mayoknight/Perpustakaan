<?php
include "koneksi.php";
session_start();

// Cek login
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit();
}

$id_pengguna = $_SESSION['id'];

// Tambah ke koleksi
if (isset($_POST['tambah_koleksi'])) {
    $id_buku = $_POST['id_buku'];

    $cek = mysqli_query($conn, "SELECT * FROM koleksi_pribadi WHERE id_pengguna='$id_pengguna' AND id_buku='$id_buku'");
    if (mysqli_num_rows($cek) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO koleksi_pribadi (id_pengguna, id_buku) VALUES ('$id_pengguna', '$id_buku')");
        $message = $insert ? "✅ Buku berhasil ditambahkan ke koleksi Anda." : "❌ Gagal menambahkan buku.";
    } else {
        $message = "ℹ️ Buku ini sudah ada di koleksi Anda.";
    }
}

// Ambil data buku
$buku = mysqli_query($conn, "SELECT * FROM data_buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Katalog Buku</title>
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

    button {
        padding: 6px 10px;
        background-color: #c49b6c;
        border: none;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #a67c52;
    }

    a.back {
        text-decoration: none;
        color: #5a3e36;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
<div class="container">
    <a href="dashboard_pengguna.php" class="back">← Kembali ke Dashboard</a>
    <h2>Katalog Buku</h2>

    <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

    <div class="book-list">
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
            <form method="post">
                <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                <button type="submit" name="tambah_koleksi">Tambah</button>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>