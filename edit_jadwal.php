<?php
session_start();

$pageTitle = "Edit Jadwal Kegiatan";
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: adminpura.php#kegiatan-admin");
    exit();
}

$sql_select = "SELECT id_kegiatan, judul, tanggal, waktu, lokasi, deskripsi_singkat, deskripsi_lengkap, status FROM jadwal_upacara WHERE id_kegiatan = ?";
if ($stmt_select = $conn->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $data = $result->fetch_assoc();
    $stmt_select->close();

    if (!$data) {
        $_SESSION['pesan_error'] = "Data jadwal tidak ditemukan.";
        header("Location: adminpura.php#kegiatan-admin");
        exit();
    }
} else {

    $error = "Error saat mengambil data: " . $conn->error;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $judul = $conn->real_escape_string($_POST['judul']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $waktu = $conn->real_escape_string($_POST['waktu']);
    $lokasi = $conn->real_escape_string($_POST['lokasi']); 
    $deskripsi_singkat = $conn->real_escape_string($_POST['deskripsi_singkat']);
    $deskripsi_lengkap = $conn->real_escape_string($_POST['deskripsi_lengkap']);
    $status = $conn->real_escape_string($_POST['status']);

  
    $sql_update = "UPDATE jadwal_upacara SET judul=?, tanggal=?, waktu=?, lokasi=?, deskripsi_singkat=?, deskripsi_lengkap=?, status=? WHERE id_kegiatan=?";
    
    if ($stmt_update = $conn->prepare($sql_update)) {
       
        $stmt_update->bind_param("sssssssi", $judul, $tanggal, $waktu, $lokasi, $deskripsi_singkat, $deskripsi_lengkap, $status, $id);
        
        if ($stmt_update->execute()) {
            $_SESSION['pesan'] = "Jadwal **" . htmlspecialchars($judul) . "** berhasil diperbarui!";
            header("Location: adminpura.php#kegiatan-admin");
            exit();
        } else {
            $error = "Gagal memperbarui jadwal: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        $error = "Error saat menyiapkan update statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="admin.css">
    
    <style>
       
        .admin-content-col {
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }
        .content-wrapper {
            flex: 1; 
            padding-bottom: 20px;
        }

        .form-control, .form-select {
            border-radius: 8px;
        }
        
        .btn-warning {
            background-color: #e6b13eff;
            border-color: #e6b13eff;
            color: #fff;
        }
        .btn-warning:hover {
            background-color: #c89a32;
            border-color: #c89a32;
            color: #fff;
        }
    </style>
</head>
<body> 
    <div class="admin-layout-wrapper">  
        <div class="admin-sidebar-col" id="adminSidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <div class="logo d-flex align-items-center">
                    <img src="images/2.png" alt="Om" class="logo-om" /> 
                    <div class="logo-text-group">
                        <span>Pura Mandira Taman Sari Kota Palopo</span>
                    </div>
                </div>
                <button class="admin-hamburger-toggle d-lg-none" id="adminCloseSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="sidebar-menu" id="adminMenu">
                <a href="adminpura.php#kegiatan-admin" class="active">
                    <i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara
                </a>
                <a href="kelola_galeri.php">
                    <i class="fas fa-images me-2"></i> Kelola Galeri
                </a>
                  <a href="kelolaadmin.php" class="nav-link">
                  <i class="fas fa-users-cog me-2"></i> Kelola Admin
                </a>
                <a href="#" id="logoutConfirmLink" class="text-danger sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            </nav>
        </div>
        
        <div class="admin-content-col">
            
            <div class="content-wrapper"> <div class="content-header-mobile d-flex justify-content-start align-items-center mb-4 d-lg-none">
                    <button class="admin-hamburger-toggle me-3" id="adminMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0"><?php echo $pageTitle; ?></h1>
                </div>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow">
                                <div class="card-header bg-warning text-white">
                                    <h3 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Jadwal: <?php echo htmlspecialchars($data['judul']); ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                    
                                    <form method="post" action="edit_jadwal.php?id=<?php echo $id; ?>">
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul Kegiatan</label>
                                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="waktu" class="form-label">Waktu (Jam)</label>
                                                <input type="time" class="form-control" id="waktu" name="waktu" value="<?php echo htmlspecialchars($data['waktu']); ?>" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lokasi" class="form-label">Lokasi Singkat</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($data['lokasi']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                                            <input type="text" class="form-control" id="deskripsi_singkat" name="deskripsi_singkat" value="<?php echo htmlspecialchars($data['deskripsi_singkat']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap</label>
                                            <textarea class="form-control" id="deskripsi_lengkap" name="deskripsi_lengkap" rows="3"><?php echo htmlspecialchars($data['deskripsi_lengkap']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="aktif" <?php if ($data['status'] == 'aktif') echo 'selected'; ?>>Aktif (Tampil)</option>
                                                <option value="nonaktif" <?php if ($data['status'] == 'nonaktif') echo 'selected'; ?>>Nonaktif (Sembunyi)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-warning me-2"><i class="fas fa-sync-alt"></i> Update Jadwal</button>
                                            <a href="adminpura.php#kegiatan-admin" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <footer class="admin-footer text-center py-3 border-top">
                <p class="text-muted small mb-0">© <?php echo date("Y"); ?> Dashboard Pura Mandira Taman Sari.</p>
            </footer>

        </div>
    </div> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('adminMenuToggle');
            const sidebar = document.getElementById('adminSidebar');
            const closeSidebar = document.getElementById('adminCloseSidebar');
            const menu = document.getElementById('adminMenu');
            const layoutWrapper = document.querySelector('.admin-layout-wrapper'); 

            const openSidebar = () => {
                sidebar.classList.add('active');
                layoutWrapper.classList.add('show-sidebar');
            };
            
            const closeSidebarFunc = () => {
                sidebar.classList.remove('active');
                layoutWrapper.classList.remove('show-sidebar');
            };
            
            if (menuToggle) {
                menuToggle.addEventListener('click', openSidebar);
            }
            
            if (closeSidebar) {
                closeSidebar.addEventListener('click', closeSidebarFunc);
            }

            if (layoutWrapper) {
                layoutWrapper.addEventListener('click', (event) => {
                    if (sidebar.classList.contains('active') && event.target === layoutWrapper) {
                         closeSidebarFunc();
                    }
                });
            }
            
            if (menu) {
                menu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', (event) => {
                        if (window.innerWidth < 992) {
                            closeSidebarFunc(); 
                        }
                        
                        menu.querySelectorAll('a').forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                    });
                });
            }
        });
    </script>
</body>
</html>