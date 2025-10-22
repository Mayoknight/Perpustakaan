<?php
include 'koneksi.php';

header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=laporan_peminjaman.doc");

$query = "
SELECT b.id_booking, p.nama_pengguna, bk.judul, b.tanggal_booking, b.status
FROM booking_buku b
JOIN pengguna p ON b.id_pengguna = p.id_pengguna
JOIN data_buku bk ON b.id_buku = bk.id_buku
ORDER BY b.tanggal_booking DESC
";
$result = $conn->query($query);
?>

<html>
<head>
  <meta charset="UTF-8">
  <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 5px;
    }
    th {
      background-color: #ccc;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Laporan Peminjaman Buku</h2>
  <table width="100%">
    <tr>
      <th>ID Booking</th>
      <th>Nama Pengguna</th>
      <th>Nama Buku</th>
      <th>Tanggal Booking</th>
      <th>Status</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id_booking'] ?></td>
      <td><?= $row['nama_pengguna'] ?></td>
      <td><?= $row['judul'] ?></td>
      <td><?= $row['tanggal_booking'] ?></td>
      <td><?= $row['status'] ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>