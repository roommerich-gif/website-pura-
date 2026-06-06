<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $_SESSION['pesan_error'] = "ID jadwal tidak valid.";
    header("Location: adminpura.php#kegiatan-admin");
    exit();
}

$judul = '';
$sql_select = "SELECT judul FROM jadwal_upacara WHERE id_kegiatan = ?";
if ($stmt_select = $conn->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $stmt_select->bind_result($judul);
    $stmt_select->fetch();
    $stmt_select->close();
}

$sql_delete = "DELETE FROM jadwal_upacara WHERE id_kegiatan = ?";

if ($stmt_delete = $conn->prepare($sql_delete)) {
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        $_SESSION['pesan'] = "Jadwal **" . htmlspecialchars($judul) . "** berhasil dihapus!";
    } else {
        $_SESSION['pesan_error'] = "Gagal menghapus jadwal: " . $stmt_delete->error;
    }
    $stmt_delete->close();
} else {
    $_SESSION['pesan_error'] = "Error preparing delete statement: " . $conn->error;
}

header("Location: adminpura.php#kegiatan-admin");
exit();
?>