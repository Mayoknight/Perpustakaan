<?php 
include "koneksi.php"; 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Library</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body {
      height: 100vh; display:flex; justify-content:center; align-items:center;
      background: #f5f0e6;
    }
    .login-container {
      background: #fff5e6; padding: 40px 50px; border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1); width: 350px; text-align: center;
    }
    .login-container h2 { margin-bottom: 25px; color: #5a3e36; }
    input[type="text"], input[type="password"] {
      width:100%; padding:12px 15px; margin-bottom:20px; border:1px solid #d9cfc4;
      border-radius:8px; background-color:#fff8f0; color:#5a3e36; font-size:14px;
    }
    input:focus { outline:none; border-color:#c49b6c; box-shadow:0 0 5px rgba(196,155,108,0.5); }
    button {
      width:100%; padding:12px; background-color:#c49b6c; border:none;
      border-radius:8px; color:#fff; font-size:16px; cursor:pointer; transition:0.3s;
    }
    button:hover { background-color:#a67c52; }
    .message { margin-top:15px; color:#5a3e36; font-weight:bold; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>

    <div class="message">
      <?php
      if (isset($_POST['login'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];

          // 🔹 1. Cek tabel petugas dulu
          $stmt = $conn->prepare("SELECT id_petugas AS id, nama_petugas AS nama, password, level FROM petugas WHERE username=?");
          $stmt->bind_param("s", $username);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
              $data = $result->fetch_assoc();
              if (password_verify($password, $data['password'])) {
                  $_SESSION['id'] = $data['id'];
                  $_SESSION['nama'] = $data['nama'];
                  $_SESSION['level'] = $data['level'];
           

                  if ($data['level'] == 'Admin') {
                      header("Location: dashboard_admin.php");
                  } else {
                      header("Location: dashboard_staff.php");
                  }
                  exit;
              } else {
                  echo "Password salah!";
              }
          } else {
              // 🔹 2. Cek tabel pengguna kalau tidak ada di petugas
              $stmt = $conn->prepare("SELECT id_pengguna AS id, nama_pengguna AS nama, password FROM pengguna WHERE username=?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                  $data = $result->fetch_assoc();
                 if (password_verify($password, $data['password'])) {
                         $_SESSION['id'] = $data['id'];
                         $_SESSION['id_pengguna'] = $data['id']; // 🔹 Tambahan biar pengembalian.php bisa kenal
                         $_SESSION['nama'] = $data['nama'];
                         $_SESSION['level'] = 'pengguna';
                         header("Location: dashboard_pengguna.php");
                         exit;
              } else {
                      echo "Password salah!";
                  }
              } else {
                  echo "Username tidak ditemukan!";
              }
          }
          $stmt->close();
      }
      ?>
    </div>
  </div>
</body>
</html>