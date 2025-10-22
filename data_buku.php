<?php
include 'koneksi.php';

$query = "SELECT data_buku.*, kategori.nama_kategori, rak.nama_rak 
          FROM data_buku
          LEFT JOIN kategori ON data_buku.id_kategori = kategori.id_kategori
          LEFT JOIN rak ON data_buku.id_rak = rak.id_rak
          ORDER BY id_buku DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Data Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{
    background:#f9f3ee;
    font-family:Poppins, sans-serif
  }

  .navbar {
      background-color: #b68d65;
    }
    .navbar-brand {
      color: white !important;
      font-weight: bold;
    }

  .card{
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.06)
  }

  .btn-custom{background:#b68d65;
    color:#fff;
    border:none
  }

  img.cover{
    width:70px;
    height:90px;
    object-fit:cover;
    border-radius:6px
    }

</style>
</head>
<body>

  <nav class="navbar navbar-expand-lg">
  <div class="container">
    <a href="<?= $_SESSION['level']=='Admin'?'dashboard_admin.php':'dashboard_staff.php' ?>" class="back">← Kembali ke Dashboard</a>
  </div>
</nav>

<div class="container my-5">
  <div class="card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Daftar Buku</h4>
      <a class="btn btn-custom" href="tambah_buku.php">+ Tambah Buku</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead style="background:#d7b89c">
          <tr><th>Foto</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Kategori</th><th>Rak</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td>
              <?php if(!empty($row['foto']) && file_exists(__DIR__.'/uploads/'.$row['foto'])): ?>
                <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" class="cover" alt="cover">
              <?php else: ?>
                <span class="text-muted">No photo</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['penulis']) ?></td>
            <td><?= htmlspecialchars($row['penerbit']) ?></td>
            <td><?= htmlspecialchars($row['tahun']) ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($row['nama_rak']) ?></td>
            <td>
              <a class="btn btn-sm btn-warning text-white" href="edit_buku.php?id=<?= $row['id_buku'] ?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="hapus_buku.php?id=<?= $row['id_buku'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>