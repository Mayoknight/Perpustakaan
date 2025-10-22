<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'pengguna') {
    header("Location: Home.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pengguna</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f5f0e6;
      color: #5a3e36;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Navbar */
    nav {
      background-color: #c49b6c;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      color: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    nav h1 {
      font-size: 22px;
      font-weight: bold;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 20px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
      padding: 8px 12px;
      border-radius: 6px;
    }

    nav ul li a:hover {
      background-color: #a67c52;
    }

    /* Content */
    .container {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .container h2 {
      font-size: 26px;
      margin-bottom: 15px;
    }

    .container p {
      color: #6d5448;
      font-size: 16px;
    }

    /* Footer */
    footer {
      background-color: #fff5e6;
      text-align: center;
      padding: 10px;
      font-size: 14px;
      color: #6d5448;
    }
  </style>
</head>
<body>

  <nav>
    <h1>Perpustakaan Digital</h1>
    <ul>
      <li><a href="katalog_buku.php">Katalog Buku</a></li>
      <li><a href="pengembalian.php">Pengembalian Buku</a></li>
      <li><a href="koleksi.php">Koleksi</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>

  <div class="container">
    <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h2>
    <p>Ini adalah dashboard pengguna. Kamu bisa meminjam, mengembalikan, memberi rating, atau melihat koleksi buku di sini.</p>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> Perpustakaan Digital | Adzfan Library System
  </footer>

</body>
</html>