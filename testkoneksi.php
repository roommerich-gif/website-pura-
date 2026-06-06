<?php
require_once 'koneksi.php';
echo "<h1>Koneksi ke Database Berhasil!</h1>";
echo "Database yang terhubung: " . $db; 
$conn->close();
?>