<?php
session_start();
include "koneksi.php";

// Pengecekan sesi
if (!isset($_SESSION['id']) || $_SESSION['level'] != 'Staff') {
    header("Location: Home.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { 
            margin: 0; 
            font-family: Arial, sans-serif; 
            background: #f0f8ff; 
        }
        .container { 
            width: 100%; /* Full Width */
            background: white; 
            padding: 30px 50px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
            box-sizing: border-box; 
            min-height: 150px;
        }
        h1 { color: #5a3e36; margin-top: 0; }
        .level { color: #c49b6c; font-weight: bold; }
        
        
        .nav-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .nav-bar a, .nav-item {
            text-decoration: none;
            background: #4caf91;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
            position: relative; 
            z-index: 10;
            list-style: none;
        }
        .nav-bar a:hover, .nav-item:hover { 
            background: #3e8c74; 
        }

       
        .dropdown-content {
            display: none; 
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            margin-top: 8px; 
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background: #f9f9f9;
            border-radius: 0;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .nav-item:hover .dropdown-content {
            display: block; 
        }

        
        .main-content {
            padding: 20px 50px;
            text-align: center;
            color: #6b4f3f;
        }
        .card-grid {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            justify-content: center;
        }
        .card {
            background: #fff5e6;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }
        .card h3 { color: #a67c52; }
        .card p { font-size: 24px; font-weight: bold; margin-top: 10px; }


        
    </style>
</head>
<body>
    <div class="container">
        <h1>Halo, Selamat datang <?php echo $_SESSION['username']; ?>!</h1>
        <p>Anda login sebagai: <span class="level">Staff</span>.</p>
        <hr>
        
        <div class="nav-bar">

        <li class="nav-item">
                Manajemen Buku
                <div class="dropdown-content">
                    <a href="data_rak.php">Data Rak</a>
                    <a href="data_kategori.php">Data Kategori</a>
                    <a href="daftar_booking.php">Data Booking Buku</a>
                      <a href="laporan.php">laporan</a>
                </div>
            </li>
            <a href="data_buku.php">Data Buku</a>
            <a href="daftar_peminjaman.php">Data Peminjaman Buku</a>
            <a href="daftar_pengembalian.php">Data Pengembalian Buku</a>
            <a href="logout.php">Logout</a>

        </div>
        
    </div>
    
    <div class="main-content">
        <h2>Statistik Perpustakaan Hari Ini</h2>
        <div class="card-grid">
            <div class="card">
                <h3>Total Buku</h3>
                <p>1,245</p>
            </div>
            <div class="card">
                <h3>Buku Dipinjam</h3>
                <p>87</p>
            </div>
            <div class="card">
                <h3>Petugas Aktif</h3>
                <p>5</p>
            </div>
        </div>
    </div>

</body>
</html>