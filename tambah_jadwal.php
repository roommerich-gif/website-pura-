<?php
session_start();

require_once 'koneksi.php'; 

$pageTitle = "Tambah Jadwal Baru";

if (!isset($_SESSION['pesan'])) {
    $_SESSION['pesan'] = "";
}
if (!isset($_SESSION['pesan_error'])) {
    $_SESSION['pesan_error'] = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi']; 
    $deskripsi_singkat = $_POST['deskripsi_singkat'];
    $deskripsi_lengkap = $_POST['deskripsi_lengkap'];
    $status = $_POST['status'];

    $sql = "INSERT INTO jadwal_upacara (judul, tanggal, waktu, lokasi, deskripsi_singkat, deskripsi_lengkap, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
    
        $stmt->bind_param("sssssss", $judul, $tanggal, $waktu, $lokasi, $deskripsi_singkat, $deskripsi_lengkap, $status);
        
        if ($stmt->execute()) {
            $_SESSION['pesan'] = "Jadwal **" . htmlspecialchars($judul) . "** berhasil ditambahkan!";
            header("Location: adminpura.php#kegiatan-admin");
            exit();
        } else {
            $_SESSION['pesan_error'] = "Gagal menambahkan jadwal: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['pesan_error'] = "Error preparing statement: " . $conn->error;
    }
    header("Location: adminpura.php#kegiatan-admin");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="admin.css"> 
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
            
            <div class="content-header-mobile d-flex justify-content-start align-items-center mb-4 d-lg-none">
                <button class="admin-hamburger-toggle me-3" id="adminMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="h3 mb-0"><?php echo $pageTitle; ?></h1>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow">
                            <div class="card-header bg-warning text-white">
                                <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Jadwal Kegiatan Baru</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="tambah_jadwal.php">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Kegiatan</label>
                                        <input type="text" class="form-control" id="judul" name="judul" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="waktu" class="form-label">Waktu (Jam)</label>
                                            <input type="time" class="form-control" id="waktu" name="waktu" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lokasi" class="form-label">Lokasi </label>
                                            <input type="text" class="form-control" id="lokasi" name="lokasi" required placeholder="Cth: Pura Mandala">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat </label>
                                        <input type="text" class="form-control" id="deskripsi_singkat" name="deskripsi_singkat" required placeholder="Cth: Perayaan hari jadi pura...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap </label>
                                        <textarea class="form-control" id="deskripsi_lengkap" name="deskripsi_lengkap" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif">Aktif (Tampil)</option>
                                            <option value="nonaktif">Nonaktif (Sembunyi)</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-warning me-2"><i class="fas fa-save"></i> Simpan Jadwal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="admin-footer text-center py-3 mt-4 border-top">
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
                        
                        const href = link.getAttribute('href');
                        if (href && href.startsWith('adminpura.php#')) {
                        } else if (href && href.startsWith('#')) {
                            event.preventDefault();
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>

<?php
if (isset($conn) && $conn) {

    $conn->close();
}
?>