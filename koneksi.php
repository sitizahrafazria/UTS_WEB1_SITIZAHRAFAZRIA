<?php
    $host = "localhost"; // Alamat server database (biaya localhost)
    $user = "root";     // Username untuk login ke database
    $password = "";     // Password untuk login (biasanya kosong localhost)
    $db = "db_penjualan_barang"; // Nama database yang ingin diakses

    // Membuat koneksi
    $koneksi = mysqli_connect($host, $user, $password, $db);

    // Mengecek koneksi
    if (!$koneksi->connect_error) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    echo "Koneksi berhasil";
?>