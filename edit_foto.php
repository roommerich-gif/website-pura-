<?php
session_start();
require_once 'koneksi.php';

$id_foto = isset($_GET['id'])  ? (int)$_GET['id']
         : (isset($_POST['id_foto']) ? (int)$_POST['id_foto'] : 0);
$foto = null;

if ($id_foto > 0) {
    $stmt = $conn->prepare("SELECT id_foto, judul_foto, deskripsi, path_file, tipe_media FROM galeri WHERE id_foto = ?");
    $stmt->bind_param("i", $id_foto);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $foto = $result->fetch_assoc();
    }
    $stmt->close();
}

if (!$foto) {
    header("Location: kelola_galeri.php");
    exit;
}

// Deteksi tipe dari ekstensi jika kolom tipe_media belum ada / null
$ext_lama  = strtolower(pathinfo($foto['path_file'], PATHINFO_EXTENSION));
$isVideoLama = ($foto['tipe_media'] === 'video') || in_array($ext_lama, ['mp4','webm','ogg']);

$error_message = "";

if (isset($_POST['update'])) {
    $judul_baru     = trim($_POST['judul']);
    $deskripsi_baru = trim($_POST['deskripsi']);
    $path_file_lama = $foto['path_file'];
    $path_file_baru = $path_file_lama;
    $tipe_baru      = $foto['tipe_media'] ?? ($isVideoLama ? 'video' : 'foto');
    $update_file    = false;

    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $file_upload = $_FILES['media'];
        $ext = strtolower(pathinfo($file_upload['name'], PATHINFO_EXTENSION));

        $allowed_foto  = ['jpg','jpeg','png','gif'];
        $allowed_video = ['mp4','webm','ogg'];

        if (!in_array($ext, array_merge($allowed_foto, $allowed_video))) {
            $error_message = "Format tidak diizinkan.";
        } elseif ($file_upload['size'] > 50 * 1024 * 1024) {
            $error_message = "File terlalu besar (Maks 50MB).";
        } else {
            $update_file   = true;
            $tipe_baru     = in_array($ext, $allowed_video) ? 'video' : 'foto';
            $path_file_baru = "images/galeri/media_" . time() . "." . $ext;
        }
    }

    if (empty($error_message)) {
        if ($update_file) {
            move_uploaded_file($file_upload['tmp_name'], $path_file_baru);
            if (file_exists($path_file_lama) && !str_contains($path_file_lama, '..')) {
                unlink($path_file_lama);
            }
        }
        $upd = $conn->prepare("UPDATE galeri SET judul_foto=?, deskripsi=?, path_file=?, tipe_media=? WHERE id_foto=?");
        $upd->bind_param("ssssi", $judul_baru, $deskripsi_baru, $path_file_baru, $tipe_baru, $id_foto);
        if ($upd->execute()) {
            echo "<script>alert('Berhasil diupdate!'); window.location='kelola_galeri.php';</script>";
            exit;
        } else {
            $error_message = "Gagal update database.";
        }
        $upd->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Media | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .admin-content-col { background: #f8f9fa; min-height: 100vh; }
        .content-wrapper { padding: 40px 20px; display: flex; justify-content: center; }
        .form-container {
            width: 100%; max-width: 520px;
            background: white; padding: 30px;
            border-radius: 14px; border-top: 5px solid #FF9900;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        .media-preview-box {
            width: 100%; height: 130px;
            border: 1px solid #ddd; border-radius: 8px;
            overflow: hidden; background: #f0f0f0;
            display: flex; align-items: center; justify-content: center;
            margin-top: 8px;
        }
        .media-preview-box img  { width: 100%; height: 100%; object-fit: cover; }
        .media-preview-box video { width: 100%; height: 100%; object-fit: cover; }
        .btn-update { background: #FF9900; color: white; font-weight: bold; border: none; }
        .btn-update:hover { background: #e68a00; color: white; }
    </style>
</head>
<body>
<div class="admin-layout-wrapper">
    <!-- Sidebar -->
    <div class="admin-sidebar-col" id="adminSidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
                <img src="images/2.png" alt="Logo" class="logo-om" />
                <div class="logo-text-group"><span>Pura Mandira Taman Sari Kota Palopo</span></div>
            </div>
            <button class="admin-hamburger-toggle d-lg-none" id="adminCloseSidebar"><i class="fas fa-times"></i></button>
        </div>
        <nav class="sidebar-menu">
            <a href="adminpura.php"><i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara</a>
            <a href="kelola_galeri.php" class="active"><i class="fas fa-images me-2"></i> Kelola Galeri</a>
            <a href="kelolaadmin.php"><i class="fas fa-users-cog me-2"></i> Kelola Admin</a>
            <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>

    <div class="admin-content-col">
        <div class="content-wrapper">
            <div class="form-container">
                <h4 class="text-center fw-bold mb-4">
                    <i class="fas fa-edit me-2"></i>Edit Media Galeri
                </h4>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2 small"><?= $error_message ?></div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_foto" value="<?= $foto['id_foto'] ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control form-control-sm"
                               value="<?= htmlspecialchars($foto['judul_foto']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($foto['deskripsi']) ?></textarea>
                    </div>

                    <!-- Preview saat ini & baru -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="text-muted" style="font-size:10px;font-weight:bold;text-transform:uppercase;">
                                <?= $isVideoLama ? 'Video' : 'Foto' ?> Saat Ini
                            </label>
                            <div class="media-preview-box">
                                <?php if ($isVideoLama): ?>
                                    <video src="<?= htmlspecialchars($foto['path_file']) ?>" controls muted></video>
                                <?php else: ?>
                                    <img src="<?= htmlspecialchars($foto['path_file']) ?>"
                                         onerror="this.src='placeholder.png'">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted" style="font-size:10px;font-weight:bold;text-transform:uppercase;">Preview Baru</label>
                            <div class="media-preview-box" id="previewBox">
                                <span class="text-muted small">—</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">
                            Ganti Media <span class="text-muted">(opsional)</span>
                            <span class="badge bg-secondary ms-1" style="font-size:.7rem">JPG/PNG · MP4/WEBM · Maks 50MB</span>
                        </label>
                        <input type="file" id="mediaInput" name="media"
                               class="form-control form-control-sm"
                               accept="image/*,video/mp4,video/webm,video/ogg">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="update" class="btn btn-update">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="kelola_galeri.php" class="btn btn-light btn-sm">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById("mediaInput").onchange = function () {
    const file = this.files[0];
    if (!file) return;
    const box = document.getElementById("previewBox");
    box.innerHTML = "";
    const url = URL.createObjectURL(file);
    if (file.type.startsWith("video/")) {
        const v = document.createElement("video");
        v.src = url; v.controls = true; v.muted = true;
        v.style.cssText = "width:100%;height:100%;object-fit:cover;";
        box.appendChild(v);
    } else {
        const img = document.createElement("img");
        img.src = url;
        img.style.cssText = "width:100%;height:100%;object-fit:cover;";
        box.appendChild(img);
    }
};

const logoutLink = document.getElementById('logoutConfirmLink');
if (logoutLink) {
    logoutLink.addEventListener('click', e => {
        e.preventDefault();
        if (confirm("Apakah Anda yakin ingin keluar?")) window.location.href = "logout.php";
    });
}
</script>
</body>
</html>