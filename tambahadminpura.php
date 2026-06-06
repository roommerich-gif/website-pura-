<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_pengurus']);
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin_users (username, password, nama_pengurus) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $hashed_password, $nama);

    if ($stmt->execute()) {
        echo "<script>alert('Admin Baru Berhasil Ditambahkan!'); window.location='kelolaadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah admin! Username mungkin sudah ada.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin | Pura Mandira Taman Sari Kota Palopo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="admin.css"> 
    <style>
        .content-wrapper { display: flex; justify-content: center; align-items: flex-start; padding-top: 50px; min-height: 80vh; }
        .form-container { width: 100%; max-width: 450px; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 6px solid #FF9900; }
    </style>
</head>
<body>
    <div class="admin-layout-wrapper">
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
                <a href="kelola_galeri.php"><i class="fas fa-images me-2"></i> Kelola Galeri</a>
                 <a href="kelolaadmin.php" class="active" class="nav-link"><i class="fas fa-users-cog me-2"></i> Kelola Admin</a>
                  <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </nav>
        </div>
        
        <div class="admin-content-col">
            <div class="content-wrapper">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold"><i class="fas fa-user-plus text-warning"></i> Tambah Admin</h3>
                    </div>
                    <form method="POST" autocomplete="off">
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_pengurus" class="form-control" placeholder="Nama..." required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username..." required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password..." required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm">Simpan Admin</button>
                        <div class="text-center mt-3"><a href="kelolaadmin.php" class="text-muted small text-decoration-none">Batal</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('adminCloseSidebar')?.addEventListener('click', () => document.getElementById('adminSidebar').classList.remove('active'));
    </script>
</body>
</html>