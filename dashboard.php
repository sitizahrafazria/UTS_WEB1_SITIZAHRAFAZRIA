<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

// cek apakah ada pengiriman data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kode_barang  = $_POST['kode_barang']   ?? '';
    $nama_barang  = $_POST['nama_barang']   ?? '';
    $harga_barang  = (int)($_POST['harga_barang']   ?? 0);
    $jumlah  = (int)($_POST['jumlah']   ?? 0);

    $_SESSION['barang'][] = [
      'kode_barang' => $kode_barang,
      'nama_barang' => $nama_barang,
      'harga_barang' => $harga_barang,
      'jumlah' => $jumlah
    ];
  }

  if (isset($_POST['hapus'])) {
    $kode_hapus = $_POST['hapus'];
    // Cari dan hapus item dari keranjang berdasarkan kode_barang
    foreach ($_SESSION['barang'] as $index => $item) {
      if ($item['kode_barang'] === $kode_hapus) {
        unset($_SESSION['barang'][$index]);
        // Reindex array setelah penghapusan
        $_SESSION['barang'] = array_values($_SESSION['barang']);
        break;
      }
    }
  }

  $barang = $_SESSION['barang'] ?? null;
  // untuk reset keranjang jika request GET
  if (isset($_GET["reset"])) {
    unset($_SESSION['barang']);
    $barang = null;
    header('location: dashboard.php');
    exit;
  }

  $grandtotal = 0;

  ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
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
        button[name="hsapus"] {
          background-color: #3578e5
          color: white;
          border: 1px solid #ccc;
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

    form {
      width: 90%;
      margin-bottom: 30px;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .container {
      display: flex;
      margin-top: -3px;
    }

    input[type="submit"],
    input[type="reset"] {
      width: 20%;
      padding: 10px;
      margin: 10px 1%;
      border: none;
      border-radius: 4px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }

    input[type="reset"] {
      background-color: white;
      color: #333;
      border: 1px solid #ccc;
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

    #kode_barang {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
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
        <form action="dashboard.php" method="POST">
            <label for="kode_barang">Kode Barang</label>
            <select name="kode_barang" id="kode_barang" required onchange="isiDataBarang()">
        <option value="">Pilih Kode Barang</option>
        <option value="BRG001">BRG001 - Sabun Mandi</option>
        <option value="BRG002">BRG002 - Sikat Gigi</option>
        <option value="BRG003">BRG003 - Pasta Gigi</option>
        <option value="BRG004">BRG004 - Shampoo</option>
        <option value="BRG005">BRG005 - Handuk</option>
      </select>
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" placeholder="Masukan Nama Barang" required>
            <label for="harga_barang">Harga</label>
            <input type="number" name="harga_barang" id="harga_barang" placeholder="Masukan Harga" required>
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" placeholder="Masukan jumlah" required>
            <div class="container">
                <input type="submit" value="Tambahkan" name= "tambah_barang">
                <input type="reset" value="Batal">
            </div>
            </form>
                
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <h2>Daftar Pembelian</h2>
    <p>Daftar pembelian dibuat secara acak tiap kali halaman dimuat</p>
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga Barang (Rp)</th>
        <th>Jumlah</th>
        <th>Total (Rp)</th>
        <th>Aksi</th>
      </tr>
    <?php
    foreach ($barang as $item) {

    $kode_barang  = $item['kode_barang'];
    $nama_barang  = $item['nama_barang'];
    $harga_barang = $item['harga_barang'];
    $jumlah       = $item['jumlah'];

    // hitung total
    $grandtotal  = $harga_barang * $jumlah;

    //hitung diskon
    if ($grandtotal  == 0 ) {
        $d = "0%";
        $diskon = 0;
    } elseif ($grandtotal < 50000) {
        $d = "5%";
        $diskon = 0.05 * $grandtotal;
    } elseif ($grandtotal < 100000) {
        $d = "10%";
        $diskon = 0.10 * $grandtotal;
    } else {
        $d = "15%";
        $diskon = 0.15 * $grandtotal;
    }

    $totalbayar = $grandtotal -$diskon;


      echo "<tr>";
        echo "<td>" . $kode_barang . "</td>";
        echo "<td>" . $nama_barang . "</td>";
        echo "<td style='text-align:right;'>" . number_format($harga_barang, 0, ',', '.') . "</td>";
        echo "<td style='text-align:center;'>" . $jumlah . "</td>";
        echo "<td style='text-align:right;'>" . number_format($grandtotal, 0, ',', '.') . "</td>";
        echo "<td style='text-align:right;'> <form method= 'post'><button type='submit' name='hapus' value=$kode_barang>Hapus</button></form></td>";
        echo "</tr>";
  }
    ?>

    <!-- Total belanja, diskon, total bayar -->
    <tr>
        <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Belanja</strong></td>
        <td style="text-align:right;"><strong><?php echo number_format($grandtotal, 0, ',', '.'); ?></strong></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align:right; padding-right:20px"><strong><?php echo "Diskon" . $d; ?></strong></td>
        <td style="text-align:right;"><strong><?php echo number_format($diskon, 0, ',', '.'); ?></strong></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align:right; padding-right:20px"><strong>Total Bayar</strong></td>
        <td style="text-align:right;"><strong><?php echo number_format($totalbayar , 0, ',', '.'); ?></strong></td>
      </tr>
    </table>

    <!-- Reset Keranjang -->
     <form action="dashboard.php" method="get" style="margin-top:20px;">

                    <input type="submit" value="Reset Keranjang" name="reset">

                </form>
                <?php endif; ?>
  </main>

    <script>
        function logout() {
            alert("Anda telah logout!");
            // contoh redirect ke halaman login
            window.location.href = "index.php";
        }

        //munculkan nama baranng, harga barang
    function isiDataBarang() {
      const kode = document.getElementById("kode_barang").value;

      const dataBarang = {
        "BRG001": {
          nama: "Sabun Mandi",
          harga: 15000
        },
        "BRG002": {
          nama: "Sikat Gigi",
          harga: 8000
        },
        "BRG003": {
          nama: "Pasta Gigi",
          harga: 12000
        },
        "BRG004": {
          nama: "Shampoo",
          harga: 20000
        },
        "BRG005": {
          nama: "Handuk",
          harga: 30000
        }
      };

      if (dataBarang[kode]) {
        document.getElementById("nama_barang").value = dataBarang[kode].nama;
        document.getElementById("harga_barang").value = dataBarang[kode].harga;
      } else {
        document.getElementById("nama_barang").value = "";
        document.getElementById("harga_barang").value = "";
      }
    }
    </script>

</body>
</html>