<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Manajemen Admin";

if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    
    if ($id_hapus != $_SESSION['id_admin']) {
        $stmt = $conn->prepare("DELETE FROM admin_users WHERE id_admin = ?");
        $stmt->bind_param("i", $id_hapus);
        if ($stmt->execute()) {
            echo "<script>alert('Admin berhasil dihapus!'); window.location='kelolaadmin.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Tidak bisa menghapus akun sendiri!'); window.location='kelolaadmin.php';</script>";
    }
}

$result = $conn->query("SELECT id_admin, username, nama_pengurus FROM admin_users ORDER BY id_admin DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> | Pura Mandira</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="admin.css"> 

    <style>
        .admin-content-col {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .content-wrapper {
            flex: 1;
            padding-bottom: 20px;
        }
        .table-wrapper {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .data-table th, .data-table td {
            vertical-align: middle;
            padding: 12px 15px;
            font-family: 'Poppins', sans-serif !important;
        }
        .action-btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .badge-anda {
            background-color: #28a745;
            color: white;
            font-size: 0.7rem;
            padding: 3px 10px;
            border-radius: 50px;
            font-weight: 600;
        }

        /* === Samakan dengan kelola_galeri === */
        .page-title-desktop {
            font-weight: 400;
            font-size: 1.6rem;
            margin-top: -8px !important;
            margin-bottom: 0.75rem !important;
            padding-top: 0 !important;
            line-height: 1.2;
        }
        .content-wrapper.container-fluid {
            padding-top: 0 !important;
        }
    </style>
</head>

<body>

<div class="admin-layout-wrapper">
    <div class="admin-sidebar-col" id="adminSidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
                <img src="images/2.png" alt="Logo" class="logo-om" /> 
                <div class="logo-text-group">
                    <span>Pura Mandira Taman Sari Kota Palopo</span>
                </div>
            </div>
            <button class="admin-hamburger-toggle d-lg-none" id="adminCloseSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="sidebar-menu" id="adminMenu">
            <a href="adminpura.php">
                <i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara
            </a>
            <a href="kelola_galeri.php">
                <i class="fas fa-images me-2"></i> Kelola Galeri
            </a>
            <a href="kelolaadmin.php" class="active">
                <i class="fas fa-users-cog me-2"></i> Kelola Admin
            </a>
            <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>

    <div class="admin-content-col">
        <div class="content-wrapper container-fluid pt-2">
            <!-- Header mobile -->
            <div class="content-header-mobile d-flex justify-content-start align-items-center mb-3 d-lg-none">
                <button class="admin-hamburger-toggle me-3" id="adminMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="h3 mb-0"><?= $pageTitle ?></h1>
            </div>

            <!-- Judul desktop — sama dengan kelola_galeri -->
            <h1 class="page-title-desktop mb-3 d-none d-lg-block"><?= $pageTitle ?></h1>

            <section class="admin-section">
                <div class="section-header mb-3">
                    <h2 class="h5 mb-0"><i class="fas fa-user-shield me-2"></i> Data Admin Sistem</h2>
                    <a href="tambahadminpura.php" class="btn btn-light btn-sm fw-bold border shadow-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Admin Baru
                    </a>
                </div>

                <div class="table-wrapper">
                    <div class="table-responsive"> 
                        <table class="data-table table table-striped table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Pengurus</th>
                                    <th>Username</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($row['nama_pengurus']); ?>
                                            <?php if ($row['id_admin'] == $_SESSION['id_admin']): ?>
                                                <span class="badge-anda ms-2">Anda</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="text-muted small">@</span><?= htmlspecialchars($row['username']); ?></td>
                                        <td>
                                            <div class="action-btn-group">
                                                <a href="editadmin.php?id=<?= $row['id_admin']; ?>" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <?php if ($row['id_admin'] != $_SESSION['id_admin']): ?>
                                                    <a href="kelolaadmin.php?hapus=<?= $row['id_admin']; ?>" 
                                                       onclick="return confirm('Hapus admin: <?= htmlspecialchars($row['nama_pengurus']); ?>?')" 
                                                       class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted italic">Data admin tidak tersedia.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </section>
        </div>

        <footer class="admin-footer text-center py-3 border-top mt-4">
            <p class="text-muted small mb-0">&copy; <?php echo date("Y"); ?> Dashboard Pura Mandira Taman Sari.</p>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('adminMenuToggle');
        const sidebar = document.getElementById('adminSidebar');
        const closeSidebar = document.getElementById('adminCloseSidebar');
        const logoutLink = document.getElementById('logoutConfirmLink');

        menuToggle?.addEventListener('click', () => sidebar.classList.add('active'));
        closeSidebar?.addEventListener('click', () => sidebar.classList.remove('active'));

        if (logoutLink) {
            logoutLink.addEventListener('click', (e) => {
                e.preventDefault();
                if (confirm("Apakah Anda yakin ingin keluar dari sistem?")) {
                    window.location.href = "logout.php";
                }
            });
        }
    });
</script>

</body>
</html>

<?php
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>