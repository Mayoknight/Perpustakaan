<?php
include 'koneksi.php';

// Ambil data laporan
$query = "
SELECT b.id_booking, p.nama_pengguna, bk.judul, b.tanggal_booking, b.status
FROM booking_buku b
JOIN pengguna p ON b.id_pengguna = p.id_pengguna
JOIN data_buku bk ON b.id_buku = bk.id_buku
ORDER BY b.tanggal_booking DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Peminjaman Buku</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <h3 class="text-center mb-4">Laporan Peminjaman Buku</h3>
  <a href="export_word.php" class="btn btn-primary mb-3">Cetak ke Word</a>
  
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID Booking</th>
        <th>Nama Pengguna</th>
        <th>Nama Buku</th>
        <th>Tanggal Booking</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= $row['id_booking'] ?></td>
          <td><?= $row['nama_pengguna'] ?></td>
          <td><?= $row['judul'] ?></td>
          <td><?= $row['tanggal_booking'] ?></td>
          <td><?= $row['status'] ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
   <a href="<?= $_SESSION['level']=='Admin'?'dashboard_admin.php':'dashboard_staff.php' ?>" class="back">← Kembali ke Dashboard</a>
</body>
</html>