<?php
session_start();
require_once 'koneksi.php';

$pageTitle = "Kelola Galeri Foto & Video";

$success_message = "";
$error_message   = "";

// === HAPUS ===
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id_foto = (int)$_GET['id'];

    $stmt_path = $conn->prepare("SELECT path_file FROM galeri WHERE id_foto = ?");
    $stmt_path->bind_param("i", $id_foto);
    $stmt_path->execute();
    $result_path = $stmt_path->get_result();

    if ($result_path->num_rows > 0) {
        $foto_data = $result_path->fetch_assoc();
        $path_file = $foto_data['path_file'];
        $stmt_path->close();

        $stmt_del = $conn->prepare("DELETE FROM galeri WHERE id_foto = ?");
        $stmt_del->bind_param("i", $id_foto);
        if ($stmt_del->execute()) {
            if ($path_file && file_exists($path_file) && !str_contains($path_file, '..')) {
                unlink($path_file);
            }
            $success_message = "Media berhasil dihapus.";
        } else {
            $error_message = "Gagal menghapus data dari database.";
        }
        $stmt_del->close();
    } else {
        $stmt_path->close();
        $error_message = "ID tidak ditemukan.";
    }
}

// === AMBIL DATA ===
$data_galeri = [];
$query  = "SELECT id_foto, judul_foto, deskripsi, path_file, tipe_media FROM galeri ORDER BY id_foto DESC";
$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data_galeri[] = $row;
    }
    $result->free();
} else {
    // Fallback: kolom tipe_media belum ada (belum ALTER TABLE)
    $query2  = "SELECT id_foto, judul_foto, deskripsi, path_file, 'foto' AS tipe_media FROM galeri ORDER BY id_foto DESC";
    $result2 = $conn->query($query2);
    if ($result2) {
        while ($row = $result2->fetch_assoc()) $data_galeri[] = $row;
        $result2->free();
    } else {
        $error_message = "Gagal mengambil data galeri.";
    }
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
        .admin-content-col { display: flex; flex-direction: column; min-height: 100vh; }
        .content-wrapper   { flex: 1; padding-bottom: 20px; }
        .table-wrapper {
            background: white; padding: 20px;
            border-radius: 14px; box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .data-table th, .data-table td {
            vertical-align: middle; font-size: 0.92rem; font-family: 'Poppins', sans-serif;
        }
        .data-table th { font-weight: 600; }
        .media-thumb {
            width: 90px; height: 65px; object-fit: cover;
            border-radius: 6px; display: block;
        }
        .video-thumb-wrapper {
            width: 90px; height: 65px; background: #111;
            border-radius: 6px; overflow: hidden; position: relative;
            display: flex; align-items: center; justify-content: center;
        }
        .video-thumb-wrapper video {
            width: 100%; height: 100%; object-fit: cover; opacity: .85;
        }
        .video-thumb-wrapper .play-icon {
            position: absolute; color: white; font-size: 1.3rem;
            pointer-events: none; text-shadow: 0 0 6px rgba(0,0,0,.7);
        }
        .badge-foto  { background: #198754; font-size: .7rem; }
        .badge-video { background: #0d6efd; font-size: .7rem; }
        .section-header { display: flex; justify-content: space-between; align-items: center; }
        .page-title-desktop { font-weight: 400; font-size: 1.6rem; margin-top: -8px; }
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
        <nav class="sidebar-menu" id="adminMenu">
            <a href="adminpura.php"><i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara</a>
            <a href="kelola_galeri.php" class="active"><i class="fas fa-images me-2"></i> Kelola Galeri</a>
            <a href="kelolaadmin.php"><i class="fas fa-users-cog me-2"></i> Kelola Admin</a>
            <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>

    <div class="admin-content-col">
        <div class="content-wrapper container-fluid pt-1">
            <!-- Header mobile -->
            <div class="content-header-mobile d-flex justify-content-start align-items-center mb-3 d-lg-none">
                <button class="admin-hamburger-toggle me-3" id="adminMenuToggle"><i class="fas fa-bars"></i></button>
                <h1 class="h3 mb-0"><?= $pageTitle ?></h1>
            </div>
            <h1 class="page-title-desktop mb-3 d-none d-lg-block"><?= $pageTitle ?></h1>

            <section class="admin-section">
                <div class="section-header mb-3">
                    <h2 class="h5 mb-0"><i class="fas fa-photo-video me-2"></i> Data Foto & Video Galeri</h2>
                    <a href="unggahfoto.php" class="btn btn-light btn-sm fw-bold border shadow-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Media Baru
                    </a>
                </div>

                <?php if ($success_message): ?>
                    <div class="alert alert-success fw-bold"><?= $success_message ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger fw-bold"><?= $error_message ?></div>
                <?php endif; ?>

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <?php if (count($data_galeri) > 0): ?>
                        <table class="data-table table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Preview</th>
                                    <th>Tipe</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data_galeri as $item): ?>
                                <?php
                                    $ext = strtolower(pathinfo($item['path_file'], PATHINFO_EXTENSION));
                                    $isVideo = ($item['tipe_media'] === 'video') || in_array($ext, ['mp4','webm','ogg']);
                                ?>
                                <tr>
                                    <td><?= $item['id_foto'] ?></td>
                                    <td>
                                        <?php if ($isVideo): ?>
                                            <div class="video-thumb-wrapper">
                                                <video src="<?= htmlspecialchars($item['path_file']) ?>" preload="metadata" muted></video>
                                                <i class="fas fa-play play-icon"></i>
                                            </div>
                                        <?php else: ?>
                                            <img src="<?= htmlspecialchars($item['path_file']) ?>"
                                                 class="media-thumb"
                                                 onerror="this.src='placeholder.png'">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($isVideo): ?>
                                            <span class="badge badge-video"><i class="fas fa-video me-1"></i>Video</span>
                                        <?php else: ?>
                                            <span class="badge badge-foto"><i class="fas fa-image me-1"></i>Foto</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($item['judul_foto']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($item['deskripsi'])) ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="edit_foto.php?id=<?= $item['id_foto'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="kelola_galeri.php?action=hapus&id=<?= $item['id_foto'] ?>"
                                               onclick="return confirm('Hapus <?= htmlspecialchars($item['judul_foto']) ?>?')"
                                               class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-photo-video fa-2x mb-2 d-block"></i>
                                Belum ada foto atau video di galeri.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

        <footer class="admin-footer text-center py-3 mt-4 border-top">
            <p class="text-muted small mb-0">© <?= date("Y") ?> Dashboard Pura Mandira Taman Sari.</p>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
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
<?php if (isset($conn) && $conn instanceof mysqli) $conn->close(); ?>