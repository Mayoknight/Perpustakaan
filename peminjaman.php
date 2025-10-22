<?php
include "koneksi.php";
session_start();

// Cek login
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit();
}

$id_pengguna = $_SESSION['id'];
$id_buku = $_GET['id_buku'] ?? null;

// Ambil data buku
$buku = mysqli_query($conn, "SELECT * FROM data_buku WHERE id_buku='$id_buku'");
$data_buku = mysqli_fetch_assoc($buku);

// Proses peminjaman
if (isset($_POST['pinjam'])) {
    $tanggal_pinjam = date("Y-m-d");
    
    // Pilih petugas secara otomatis (misalnya 1 atau 3)
    $result = mysqli_query($conn, "SELECT id_petugas FROM petugas ORDER BY RAND() LIMIT 1");
    $petugas = mysqli_fetch_assoc($result);
    $id_petugas = $petugas['id_petugas'];

    $insert = mysqli_query($conn, "INSERT INTO peminjaman (id_pengguna, id_petugas, id_buku, tanggal_pinjam)
                                   VALUES ('$id_pengguna', '$id_petugas', '$id_buku', '$tanggal_pinjam')");
    if ($insert) {
        $success = true;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Peminjaman Buku</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: #f5f0e6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    background: #fff5e6;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    padding: 30px;
    width: 400px;
    text-align: center;
}
.card img {
    width: 120px; height: 160px;
    border-radius: 10px;
    margin-bottom: 15px;
    object-fit: cover;
}
h2 { color: #5a3e36; margin-bottom: 10px; }
p { color: #7a6f66; margin: 5px 0; }
button {
    margin-top: 15px;
    padding: 10px 15px;
    background-color: #c49b6c;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
button:hover { background-color: #a67c52; }
a {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #5a3e36;
}
.modal {
    display: <?php echo isset($success) ? 'flex' : 'none'; ?>;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    justify-content: center; align-items: center;
    background: rgba(0,0,0,0.5);
}
.modal-content {
    background: #fff5e6;
    padding: 30px 50px;
    border-radius: 15px;
    text-align: center;
    color: #5a3e36;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
</head>
<body>
<div class="card">
    <?php if ($data_buku) { ?>
        <img src="uploads/<?php echo $data_buku['foto']; ?>" alt="Cover Buku">
        <h2><?php echo $data_buku['judul']; ?></h2>
        <p><strong>Penulis:</strong> <?php echo $data_buku['penulis']; ?></p>
        <p><strong>Penerbit:</strong> <?php echo $data_buku['penerbit']; ?></p>
        <p><strong>Tahun:</strong> <?php echo $data_buku['tahun']; ?></p>
        <form method="post">
            <button type="submit" name="pinjam">Pinjam Sekarang</button>
        </form>
        <a href="koleksi.php">← Kembali ke Koleksi</a>
    <?php } else { ?>
        <p>Data buku tidak ditemukan.</p>
        <a href="koleksi.php">← Kembali</a>
    <?php } ?>
</div>

<div class="modal" id="popup">
  <div class="modal-content">
      <h3>✅ Peminjaman Berhasil!</h3>
      <p>Buku berhasil dipinjam.</p>
      <a href="pengembalian.php"><button>Lanjut ke Pengembalian</button></a>
  </div>
</div>
</body>
</html>