<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id_admin = $_GET['id'] ?? null;
if (!$id_admin) { header("Location: kelolaadmin.php"); exit; }


$stmt = $conn->prepare("SELECT username, nama_pengurus FROM admin_users WHERE id_admin = ?");
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_baru = trim($_POST['nama_pengurus']);
    $user_baru = trim($_POST['username']);
    $pass_baru = $_POST['password'];

    if (!empty($pass_baru)) {
        $hashed_pass = password_hash($pass_baru, PASSWORD_DEFAULT);
        $sql = "UPDATE admin_users SET username = ?, nama_pengurus = ?, password = ? WHERE id_admin = ?";
        $upd = $conn->prepare($sql);
        $upd->bind_param("sssi", $user_baru, $nama_baru, $hashed_pass, $id_admin);
    } else {
        $sql = "UPDATE admin_users SET username = ?, nama_pengurus = ? WHERE id_admin = ?";
        $upd = $conn->prepare($sql);
        $upd->bind_param("ssi", $user_baru, $nama_baru, $id_admin);
    }

    if ($upd->execute()) {
        echo "<script>alert('Data diperbarui!'); window.location='kelolaadmin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin | Pura Mandira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="admin.css"> 
    <style>
        .content-wrapper { display: flex; justify-content: center; align-items: flex-start; padding-top: 50px; }
        .form-box { background: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 450px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); border-top: 5px solid #FF9900; }
        
        .mobile-header { display: none; background: #fff; padding: 15px; border-bottom: 1px solid #ddd; }
        @media (max-width: 991.98px) {
            .mobile-header { display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 999; }
        }
    </style>
</head>
<body>
    <div class="admin-layout-wrapper">
        <div class="admin-sidebar-col" id="adminSidebar">
             <div class="sidebar-header d-flex justify-content-between align-items-center">
                <div class="logo d-flex align-items-center">
                    <img src="images/2.png" alt="Logo" class="logo-om" />
                    <span>Pura Mandira Taman Sari Kota Palopo</span>
                </div>
                <button class="btn text-white d-lg-none" id="adminCloseSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-menu">
                <a href="adminpura.php"><i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara</a>
                <a href="kelola_galeri.php"><i class="fas fa-images me-2"></i> Kelola Galeri</a>
                <a href="kelolaadmin.php" class="active"><i class="fas fa-users-cog me-2"></i> Kelola Admin</a>
                <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </nav>
        </div>
        <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
        <div class="admin-content-col">
            <div class="mobile-header d-lg-none">
                <div class="d-flex align-items-center">
                    <img src="images/2.png" alt="Logo" style="width: 30px;" class="me-2">
                    <span class="fw-bold">Pura Mandira</span>
                </div>
                <button class="btn btn-dark" id="adminHamburgerToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="content-wrapper">
                <div class="form-box">
                    <h3 class="text-center mb-4"><i class="fas fa-user-edit"></i> Edit Data Admin</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_pengurus" class="form-control" value="<?php echo htmlspecialchars($admin['nama_pengurus']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tak diubah">
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Simpan Perubahan</button>
                        <div class="text-center mt-3"><a href="kelolaadmin.php" class="text-muted small">Batal</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const openBtn = document.getElementById('adminHamburgerToggle');
        const closeBtn = document.getElementById('adminCloseSidebar');

        if(openBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.add('active');
            });
        }

        if(closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('active');
            });
        }
    </script>
</body>
</html>