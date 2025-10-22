<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit();
}

$id_pengguna = $_SESSION['id'];

// Proses pengembalian buku
if (isset($_POST['kembalikan'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_petugas = $_SESSION['id_petugas'] ?? 1; // default kalau belum ada
    $tanggal_kembali = date('Y-m-d');
    $denda = 0;

    // Masukkan data ke tabel pengembalian
    $query_insert = "INSERT INTO pengembalian (id_peminjaman, id_petugas, tanggal_kembali, denda)
                     VALUES ('$id_peminjaman', '$id_petugas', '$tanggal_kembali', '$denda')";

    if ($conn->query($query_insert)) {
        // Setelah insert berhasil, hapus dari peminjaman
        $query_delete = "DELETE FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'";
        $conn->query($query_delete);

        echo "<script>
            alert('Buku berhasil dikembalikan!');
            window.location.href='dashboard_pengguna.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengembalikan buku.');</script>";
    }
}

// Ambil data buku yang sedang dipinjam oleh pengguna
$query = "
    SELECT p.id_peminjaman, b.foto, b.judul, b.penulis, b.tahun
    FROM peminjaman p
    JOIN data_buku b ON p.id_buku = b.id_buku
    WHERE p.id_pengguna = '$id_pengguna'
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 85%;
            margin: 40px auto;
            background: #f5f0e6;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #5a3e36;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #dcdde1;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #c49b6c;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f2f6;
        }
        img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        button {
            background-color: #7a6f66;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #c49b6c;
        }
        .back-btn {
            display: block;
            margin-top: 25px;
            background-color: #5a3e36;
            padding: 10px 18px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
        .back-btn:hover {
            background-color: #c49b6c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengembalian Buku</h2>
        <table>
            <tr>
                <th>Foto</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Buku"></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['penulis']); ?></td>
                        <td><?php echo htmlspecialchars($row['tahun']); ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Kembalikan buku ini?')">
                                <input type="hidden" name="id_peminjaman" value="<?php echo $row['id_peminjaman']; ?>">
                                <button type="submit" name="kembalikan">Kembalikan</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Tidak ada buku yang sedang dipinjam.</td></tr>
            <?php endif; ?>
        </table>

        <a href="dashboard_pengguna.php" class="back-btn">⬅ Kembali ke Dashboard</a>
    </div>
</body>
</html>