<?php
include "koneksi.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM data_buku WHERE id_buku = '$id'");
$data = mysqli_fetch_assoc($result);

// Ambil semua kategori dan rak
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
$rak_query = mysqli_query($conn, "SELECT * FROM rak");

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $id_kategori = $_POST['id_kategori'];
    $id_rak = $_POST['id_rak'];
    $foto_lama = $data['foto'];

    // Cek apakah upload folder ada, kalau belum buat
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Upload foto baru jika ada
    if ($_FILES['foto']['name'] != "") {
        $foto_baru = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $path = "uploads/" . $foto_baru;

        if (move_uploaded_file($tmp, $path)) {
            // hapus foto lama
            if (!empty($foto_lama) && file_exists("uploads/$foto_lama")) {
                unlink("uploads/$foto_lama");
            }
            $foto_final = $foto_baru;
        } else {
            echo "<script>alert('Gagal upload foto baru! Gunakan file lain atau cek izin folder.');</script>";
            $foto_final = $foto_lama;
        }
    } else {
        $foto_final = $foto_lama;
    }

    // Update data
    $query = "UPDATE data_buku SET 
                judul='$judul', 
                penulis='$penulis', 
                penerbit='$penerbit', 
                tahun='$tahun', 
                id_kategori='$id_kategori', 
                id_rak='$id_rak', 
                foto='$foto_final'
              WHERE id_buku='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='data_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f3ee; /* coklat muda lembut */
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #b68d65;
    }
    .navbar-brand {
      color: white !important;
      font-weight: bold;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }
    .btn-custom {
      background-color: #b68d65;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #9f7953;
      color: white;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="data_buku.php">← Kembali</a>
  </div>
</nav>

<div class="container my-5">
  <div class="card p-4">
    <h4 class="fw-bold mb-4 text-center">Edit Buku</h4>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Penulis</label>
        <input type="text" name="penulis" class="form-control" value="<?= $data['penulis'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Penerbit</label>
        <input type="text" name="penerbit" class="form-control" value="<?= $data['penerbit'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Tahun</label>
        <input type="number" name="tahun" class="form-control" value="<?= $data['tahun'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="id_kategori" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          <?php while($k = mysqli_fetch_assoc($kategori_query)) { ?>
            <option value="<?= $k['id_kategori'] ?>" <?= $data['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
              <?= $k['nama_kategori'] ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Rak</label>
        <select name="id_rak" class="form-select" required>
          <option value="">-- Pilih Rak --</option>
          <?php while($r = mysqli_fetch_assoc($rak_query)) { ?>
            <option value="<?= $r['id_rak'] ?>" <?= $data['id_rak'] == $r['id_rak'] ? 'selected' : '' ?>>
              <?= $r['nama_rak'] ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Foto Buku</label><br>
        <?php if (!empty($data['foto'])) { ?>
          <img src="uploads/<?= $data['foto'] ?>" alt="Foto Buku" width="120" class="mb-2 rounded shadow">
        <?php } ?>
        <input type="file" name="foto" class="form-control">
        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
      </div>

      <div class="text-center">
        <button type="submit" name="submit" class="btn btn-custom px-5">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>