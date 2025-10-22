<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Library</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f5f0e6;
    }
    .register-container {
      background: #fff5e6;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 400px;
      text-align: center;
    }
    h2 { margin-bottom: 25px; color: #5a3e36; }
    input, select {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 20px;
      border: 1px solid #d9cfc4;
      border-radius: 8px;
      background-color: #fff8f0;
      color: #5a3e36;
      font-size: 14px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #c49b6c;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover { background-color: #a67c52; }
    .message { margin-top: 15px; color: #5a3e36; font-weight: bold; }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Form Registrasi</h2>
    <form method="post">
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="text" name="alamat" placeholder="Alamat" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>

      <!-- kolom email hanya muncul jika pilih pengguna -->
      <input type="email" name="email" id="emailField" placeholder="Email (untuk pengguna)" style="display:none;">

      <select name="level" id="levelSelect" required>
        <option value="">--Pilih Level--</option>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="pengguna">Pengguna</option>
      </select>

      <button type="submit" name="register">Register</button>
    </form>

    <div class="message">
    <?php
    if (isset($_POST['register'])) {
        $nama     = $_POST['nama'];
        $alamat   = $_POST['alamat'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $level    = $_POST['level'];
        $email    = $_POST['email'];

        if ($level == "admin" || $level == "staff") {
            $sql = "INSERT INTO petugas (nama_petugas, alamat, username, password, level) 
                    VALUES ('$nama','$alamat','$username','$password','$level')";
        } elseif ($level == "pengguna") {
            $sql = "INSERT INTO pengguna (nama_pengguna, email, alamat, username, password) 
                    VALUES ('$nama','$email','$alamat','$username','$password')";
        } else {
            $sql = "";
        }

        if (!empty($sql) && mysqli_query($conn, $sql)) {
            echo "Registrasi berhasil! <a href='Login.php'>Login disini</a>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
    </div>
  </div>

  <script>
    const levelSelect = document.getElementById('levelSelect');
    const emailField = document.getElementById('emailField');
    levelSelect.addEventListener('change', function() {
      if (this.value === 'pengguna') {
        emailField.style.display = 'block';
      } else {
        emailField.style.display = 'none';
      }
    });
  </script>
</body>
</html>