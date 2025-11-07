<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}


    $kode_barang = [
        'K001', 'K002', 'K003', 'K004', 'K005'
    ];

     $nama_barang = [
        'Teh Pucuk',
        'Sukro',
        'Sprite',
        'Coca Cola',
        'Chitose'
    ];

    $harga_barang = [
        3000, 2500, 5000, 6000, 4000
    ];
    
    $jumlah = count($nama_barang) - 1;
    $beli = 0;
    $total = 0;
    $grandtotal = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - POLGAN MART</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fb;
            margin: 0;
            padding: 0;
        }

        /* ===== Header ===== */
        header {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 30px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo {
            background-color: #3578e5;
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .title h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .title p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        .header-right {
            text-align: right;
        }

        .header-right p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .header-right span {
            font-size: 12px;
            color: #777;
        }

        .logout-btn {
            margin-top: 5px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 6px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #f0f0f0;
        }

        /* ===== Konten utama ===== */
        .container {
            margin: 40px 20px;
            text-align: left;
        }

        h2 {
            margin: 0 0 5px 0;
            color: #333;
        }

        p {
            margin: 0;
            color: #555;
            font-size: 14px;
        }

        button {
            margin-top: 10px;
            background-color: #ffffff;
            color: #333;
            border: 1px solid #ccc;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #f0f0f0;
        }

        main {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    table {
      width: 80%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="header-left">
            <div class="logo">PM</div>
            <div class="title">
                <h2>--POLGAN MART--</h2>
                <p>Sistem Penjualan Sederhana</p>
            </div>
        </div>

        <div class="header-right">
            <p><strong>Selamat datang, admin!</strong><br><span>Role: Dosen</span></p>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </header>

    <main>
    <h2>Daftar Pembelian</h2>
    <p>Daftar pembelian dibuat secara acak tiap kali halaman dimuat</p>
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga Barang (Rp)</th>
        <th>Jumlah</th>
        <th>Total (Rp)</th>
      </tr>

    <?php
    for ($i = 0; $i < rand(1, $jumlah); $i++) {
      $beli = rand(1, 10);
      $id_barang = rand(0, $jumlah);
      $harga = $harga_barang[$i] * $beli;
      $total = $harga_barang[$i] * $beli;
      $grandtotal += $total;

      echo "<tr>";
        echo "<td>" . $kode_barang[$id_barang] . "</td>";
        echo "<td>" . $nama_barang[$id_barang] . "</td>";
        echo "<td style='text-align:right;'>" . number_format($harga_barang[$id_barang], 0, ',', '.') . "</td>";
        echo "<td style='text-align:center;'>" . $beli . "</td>";
        echo "<td style='text-align:right;'>" . number_format($total, 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    
    ?>
    <tr>
        <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Belanja</strong></td>
        <td style="text-align:right;"><strong><?php echo number_format($grandtotal, 0, ',', '.'); ?></strong></td>
      </tr>
    </table>

  </main>
    <script>
        function logout() {
            alert("Anda telah logout!");
            // contoh redirect ke halaman login
            window.location.href = "index.php";
        }
    </script>
</body>
</html>