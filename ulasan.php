<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: login.php");
    exit;
}

$id_pengguna = $_SESSION['id'];
$id_buku = $_GET['id_buku'] ?? null;

if (!$id_buku) {
    echo "<script>alert('Buku tidak ditemukan!'); window.location='koleksi.php';</script>";
    exit;
}

// ambil data buku
$buku = $conn->query("SELECT * FROM data_buku WHERE id_buku='$id_buku'")->fetch_assoc();

// proses kirim ulasan
if (isset($_POST['kirim'])) {
    $ulasan = mysqli_real_escape_string($conn, $_POST['ulasan']);
    $rating = intval($_POST['rating']);
    $waktu = date("Y-m-d H:i:s");

    $insert = $conn->query("INSERT INTO ulasan_buku (id_pengguna, id_buku, ulasan, rating, waktu)
                            VALUES ('$id_pengguna', '$id_buku', '$ulasan', '$rating', '$waktu')");

    if ($insert) {
        echo "<script>
                alert('Ulasan berhasil dikirim!');
                window.location='dashboard_pengguna.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengirim ulasan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='id'>
<head>
<meta charset='UTF-8'>
<title>Ulas Buku</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f0e6;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        background: #fff5e6;
        margin: 60px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #5a3e36; margin-bottom: 20px; }
    .book-info {
        text-align: center;
        margin-bottom: 20px;
    }
    .book-info img {
        width: 120px; height: 160px; object-fit: cover;
        border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .book-info h3 {
        color: #5a3e36; margin: 10px 0 5px;
    }
    textarea {
        width: 100%; height: 100px;
        border: 1px solid #d9cfc4; border-radius: 8px;
        padding: 10px; background: #fff8f0; resize: none;
        color: #5a3e36; font-size: 14px;
    }
    .rating {
        display: flex; justify-content: center; gap: 8px;
        margin: 15px 0;
    }
    .rating input { display: none; }
    .rating label {
        font-size: 28px; color: #ccc; cursor: pointer; transition: 0.3s;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #c49b6c;
    }
    button {
        display: block; width: 100%; padding: 12px;
        background-color: #c49b6c; border: none; border-radius: 8px;
        color: #fff; font-size: 16px; cursor: pointer; transition: 0.3s;
    }
    button:hover { background-color: #a67c52; }
    .back-btn {
        display: block; text-align: center; margin-top: 15px;
        color: #5a3e36; text-decoration: none; font-weight: bold;
    }
</style>
</head>
<body>
<div class='container'>
    <h2>Ulas Buku</h2>
    <div class='book-info'>
        <img src='uploads/<?php echo htmlspecialchars($buku['foto']); ?>' alt='Foto Buku'>
        <h3><?php echo htmlspecialchars($buku['judul']); ?></h3>
        <p><i><?php echo htmlspecialchars($buku['pengarang']); ?></i></p>
    </div>

    <form method='post'>
        <textarea name='ulasan' placeholder='Tulis ulasanmu di sini...' required></textarea>
        
        <div class='rating'>
            <?php for ($i=5; $i>=1; $i--): ?>
                <input type='radio' name='rating' id='star<?php echo $i; ?>' value='<?php echo $i; ?>' required>
                <label for='star<?php echo $i; ?>'>★</label>
            <?php endfor; ?>
        </div>

        <button type='submit' name='kirim'>Kirim Ulasan</button>
    </form>
    <a href='koleksi.php' class='back-btn'>← Kembali ke Koleksi</a>
</div>
</body>
</html>