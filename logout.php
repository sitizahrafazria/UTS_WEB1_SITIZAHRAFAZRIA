<?php
session_start();

//menghapus semua session
session_unset();
session_destroy();

//kembali ke halaman login
header("Location: index.php");
exit;
?>