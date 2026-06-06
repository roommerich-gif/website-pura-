<?php

date_default_timezone_set('Asia/Makassar'); 


$host = "localhost";
$user = "root"; 
$pass = ""; 
$db = "pura_mandira_taman_sari"; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi ke database GAGAL: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (!$conn->query("SET time_zone = '+08:00'")) {
}

if (!function_exists('bulan_indonesia')) {
    function bulan_indonesia($bulan_inggris) {
        $month = [
            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 
            'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 
            'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 
            'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
        ];
        $key = substr($bulan_inggris, 0, 3);
        return $month[$key] ?? $bulan_inggris;
    }
}
?>