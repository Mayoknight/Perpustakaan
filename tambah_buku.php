<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// ambil kategori & rak untuk dropdown
$kategori_q = mysqli_query($conn, "SELECT * FROM kategori");
$rak_q = mysqli_query($conn, "SELECT * FROM rak");

if (isset($_POST['simpan'])) {
    // escape input
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $id_kategori = (int)$_POST['id_kategori'];
    $id_rak = (int)$_POST['id_rak'];

    // handle upload foto
    $fotoName = '';
    if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === 0) {
        // pastikan folder uploads ada
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/','', basename($_FILES['foto']['name']));
        // jaga agar nama unik
        $target = $uploadDir . $fotoName;
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            die("Gagal upload file. Periksa izin folder uploads.");
        }
    }

    $sql = "INSERT INTO data_buku (id_kategori, id_rak, judul, penulis, penerbit, tahun, foto)
            VALUES ('$id_kategori', '$id_rak', '$judul', '$penulis', '$penerbit', '$tahun', '".mysqli_real_escape_string($conn,$fotoName)."')";

    if (!mysqli_query($conn, $sql)) {
        die("Query gagal: " . mysqli_error($conn));
    }

    header("Location: data_buku.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{
    background:#f9f3ee;
    font-family:Poppins, sans-serif
  }
  
  
  .card{
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06)
  }

  .btn-custom{
    background:#b68d65;
    color:#fff;
    border:none
  }

  .btn-custom:hover{
    background:#9f7953
    }
</style>
</head>
<body>



<div class="container my-5">
  <div class="card p-4 col-md-6 mx-auto">
    <h4 class="text-center mb-3">Tambah Buku</h4>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3"><label>Judul</label><input class="form-control" name="judul" required></div>
      <div class="mb-3"><label>Penulis</label><input class="form-control" name="penulis" required></div>
      <div class="mb-3"><label>Penerbit</label><input class="form-control" name="penerbit" required></div>
      <div class="mb-3"><label>Tahun</label><input class="form-control" name="tahun" type="number" min="1000" max="9999" required></div>

      <div class="mb-3">
        <label>Kategori</label>
        <select class="form-select" name="id_kategori" required>
          <option value="">-- Pilih Kategori --</option>
          <?php mysqli_data_seek($kategori_q,0); while($k = mysqli_fetch_assoc($kategori_q)){ ?>
            <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Rak</label>
        <select class="form-select" name="id_rak" required>
          <option value="">-- Pilih Rak --</option>
          <?php mysqli_data_seek($rak_q,0); while($r = mysqli_fetch_assoc($rak_q)){ ?>
            <option value="<?= $r['id_rak'] ?>"><?= htmlspecialchars($r['nama_rak']) ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Foto Buku (opsional)</label>
        <input class="form-control" type="file" name="foto" accept="image/*">
      </div>

      <button class="btn btn-custom w-100" type="submit" name="simpan">Simpan</button>
    </form>
  </div>
</div>
</body>
</html>