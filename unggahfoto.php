<?php
session_start();
$pageTitle = "Unggah Foto/Video Baru";
require_once 'koneksi.php';

$upload_dir = 'images/galeri/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul      = trim($_POST['judul_foto'] ?? '');
    $deskripsi  = trim($_POST['deskripsi'] ?? '');
    $status     = $_POST['status'] ?? 'nonaktif';

    if (isset($_FILES['file_media']) && $_FILES['file_media']['error'] == 0) {
        $file_temp          = $_FILES['file_media']['tmp_name'];
        $file_name_original = $_FILES['file_media']['name'];
        $file_size          = $_FILES['file_media']['size'];
        $file_ext           = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        $allowed_foto  = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_video = ['mp4', 'webm', 'ogg'];
        $semua_allowed = array_merge($allowed_foto, $allowed_video);

        if (!in_array($file_ext, $semua_allowed)) {
            $_SESSION['pesan_error'] = "Format tidak diizinkan. Gunakan JPG/PNG/GIF untuk foto atau MP4/WEBM/OGG untuk video.";
        } elseif ($file_size > 50 * 1024 * 1024) { // Maks 50MB
            $_SESSION['pesan_error'] = "Ukuran file terlalu besar (Maks 50MB).";
        } else {
            $tipe_media      = in_array($file_ext, $allowed_video) ? 'video' : 'foto';
            $nama_file_unik  = uniqid('media_', true) . '.' . $file_ext;
            $file_path_target = $upload_dir . $nama_file_unik;

            if (move_uploaded_file($file_temp, $file_path_target)) {
                $sql = "INSERT INTO galeri (judul_foto, deskripsi, path_file, tipe_media, status, tanggal_upload)
                        VALUES (?, ?, ?, ?, ?, NOW())";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sssss", $judul, $deskripsi, $file_path_target, $tipe_media, $status);
                    if ($stmt->execute()) {
                        $_SESSION['pesan'] = "Media berhasil diunggah!";
                        header("Location: kelola_galeri.php");
                        exit();
                    } else {
                        $_SESSION['pesan_error'] = "Gagal simpan ke database: " . $stmt->error;
                        unlink($file_path_target);
                    }
                    $stmt->close();
                } else {
                    $_SESSION['pesan_error'] = "Error prepare: " . $conn->error;
                }
            } else {
                $_SESSION['pesan_error'] = "Gagal upload. Pastikan folder <strong>images/galeri/</strong> ada dan bisa ditulis.";
            }
        }
    } else {
        $_SESSION['pesan_error'] = "Belum ada file yang dipilih atau terjadi error upload.";
    }

    header("Location: unggahfoto.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
        .form-container {
            max-width: 520px; margin: 40px auto;
            background: white; padding: 32px;
            border-radius: 14px; border-top: 5px solid #FF9900;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        .preview-box {
            width: 100%; height: 180px;
            border: 2px dashed #dee2e6; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; background: #f8f9fa; margin-top: 10px;
        }
        .preview-box img, .preview-box video { max-width: 100%; max-height: 100%; border-radius: 8px; }
        .preview-placeholder { color: #aaa; font-size: 0.85rem; text-align: center; }
        .btn-upload { background: #FF9900; color: white; font-weight: 600; border: none; }
        .btn-upload:hover { background: #e68a00; color: white; }
        .badge-tipe { font-size: 0.75rem; }
    </style>
</head>
<body>
<div class="admin-layout-wrapper">
    <!-- Sidebar -->
    <div class="admin-sidebar-col" id="adminSidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
                <img src="images/2.png" alt="Om" class="logo-om" />
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
        <div class="content-wrapper container-fluid pt-4">
            <!-- Header mobile -->
            <div class="d-flex align-items-center mb-3 d-lg-none">
                <button class="admin-hamburger-toggle me-3" id="adminMenuToggle"><i class="fas fa-bars"></i></button>
                <h1 class="h4 mb-0"><?= $pageTitle ?></h1>
            </div>
            <h1 class="h4 fw-semibold mb-4 d-none d-lg-block"><?= $pageTitle ?></h1>

            <div class="form-container">
                <h5 class="fw-bold mb-4 text-center">
                    <i class="fas fa-cloud-upload-alt me-2 text-warning"></i>Unggah Foto / Video
                </h5>

                <?php if (isset($_SESSION['pesan_error'])): ?>
                    <div class="alert alert-danger small"><?= $_SESSION['pesan_error']; unset($_SESSION['pesan_error']); ?></div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Judul</label>
                        <input type="text" name="judul_foto" class="form-control form-control-sm" placeholder="Judul foto atau video" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Deskripsi <span class="text-muted">(opsional)</span></label>
                        <textarea name="deskripsi" class="form-control form-control-sm" rows="2" placeholder="Keterangan singkat..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Pilih File
                            <span class="badge bg-secondary badge-tipe ms-1">Foto: JPG/PNG/GIF · Video: MP4/WEBM (Maks 50MB)</span>
                        </label>
                        <input type="file" id="fileInput" name="file_media" class="form-control form-control-sm"
                               accept="image/*,video/mp4,video/webm,video/ogg" required>
                        <div class="preview-box" id="previewBox">
                            <div class="preview-placeholder" id="previewPlaceholder">
                                <i class="fas fa-photo-video fa-2x d-block mb-1"></i>
                                Preview akan muncul di sini
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Status Tampilan</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="aktif">Aktif (Tampil di Galeri)</option>
                            <option value="nonaktif">Nonaktif (Sembunyi)</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-upload">
                            <i class="fas fa-save me-1"></i> Unggah & Simpan
                        </button>
                        <a href="kelola_galeri.php" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <footer class="admin-footer text-center py-3 mt-4 border-top">
            <p class="text-muted small mb-0">© <?= date("Y") ?> Dashboard Pura Mandira Taman Sari.</p>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput  = document.getElementById('fileInput');
    const previewBox = document.getElementById('previewBox');
    const placeholder = document.getElementById('previewPlaceholder');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Hapus preview lama
        previewBox.querySelectorAll('img, video').forEach(el => el.remove());
        placeholder.style.display = 'none';

        const url = URL.createObjectURL(file);
        if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = url;
            video.controls = true;
            video.style.maxWidth = '100%';
            video.style.maxHeight = '180px';
            previewBox.appendChild(video);
        } else {
            const img = document.createElement('img');
            img.src = url;
            previewBox.appendChild(img);
        }
    });

    // Sidebar toggle
    const menuToggle   = document.getElementById('adminMenuToggle');
    const sidebar      = document.getElementById('adminSidebar');
    const closeSidebar = document.getElementById('adminCloseSidebar');
    if (menuToggle)   menuToggle.addEventListener('click', () => sidebar.classList.add('active'));
    if (closeSidebar) closeSidebar.addEventListener('click', () => sidebar.classList.remove('active'));

    const logoutLink = document.getElementById('logoutConfirmLink');
    if (logoutLink) {
        logoutLink.addEventListener('click', e => {
            e.preventDefault();
            if (confirm("Apakah Anda yakin ingin keluar?")) window.location.href = "logout.php";
        });
    }
});
</script>
</body>
</html>