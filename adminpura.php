<?php
session_start();

$pageTitle = "Kelola Jadwal Kegiatan | Pura Mandira Taman Sari"; 
require_once 'koneksi.php'; 

if (!function_exists('bulan_indonesia')) {
    function bulan_indonesia($bulan_inggris) {
        $month = [
            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 
            'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 
            'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 
            'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
        ];
        return $month[$bulan_inggris] ?? $bulan_inggris; 
    }
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
        .table-wrapper {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .data-table th, .data-table td {
            vertical-align: middle;
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.9rem;
        }
        .data-table th {
            font-weight: 600;
            font-family: 'Poppins', sans-serif !important;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            <a href="adminpura.php" class="active">
                <i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara
            </a>
            <a href="kelola_galeri.php">
                <i class="fas fa-images me-2"></i> Kelola Galeri
            </a>
            <a href="kelolaadmin.php">
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
                <h1 class="h3 mb-0">Kelola Jadwal Kegiatan</h1>
            </div>
            
            <!-- Judul desktop -->
            <h1 class="page-title-desktop mb-3 d-none d-lg-block">Kelola Jadwal Kegiatan</h1>

            <!-- Tabel Jadwal -->
            <section id="kegiatan-admin" class="admin-section">
                <div class="section-header mb-3">
                    <h2 class="h5 mb-0"><i class="fas fa-list-ul me-2"></i> Data Jadwal Upacara & Kegiatan</h2>
                    <a href="tambah_jadwal.php" class="btn btn-light btn-sm fw-bold border shadow-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Jadwal Baru
                    </a>
                </div>
                
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="data-table table table-striped table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id_kegiatan, judul, tanggal, waktu, status FROM jadwal_upacara ORDER BY tanggal DESC"; 
                                $result = isset($conn) ? $conn->query($sql) : null;

                                if ($result && $result->num_rows > 0): while ($row = $result->fetch_assoc()):
                                    $tanggal_obj = new DateTime($row['tanggal']); 
                                ?>
                                <tr>
                                    <td><?php echo $row['id_kegiatan']; ?></td>
                                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                    <td><?php echo $tanggal_obj->format('d') . ' ' . bulan_indonesia($tanggal_obj->format('M')) . ' ' . $tanggal_obj->format('Y'); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['waktu'])); ?></td>
                                    <td><span class="badge bg-<?php echo ($row['status'] == 'aktif') ? 'success' : 'secondary'; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="edit_jadwal.php?id=<?php echo $row['id_kegiatan']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="hapus_jadwal.php?id=<?php echo $row['id_kegiatan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus: <?php echo htmlspecialchars($row['judul']); ?>?')" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data jadwal kegiatan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

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
        const layoutWrapper = document.querySelector('.admin-layout-wrapper');
        const logoutLink = document.getElementById('logoutConfirmLink');

        menuToggle?.addEventListener('click', () => sidebar.classList.add('active'));
        closeSidebar?.addEventListener('click', () => sidebar.classList.remove('active'));

        if (layoutWrapper) {
            layoutWrapper.addEventListener('click', (event) => {
                if (sidebar.classList.contains('active') && event.target === layoutWrapper) {
                    sidebar.classList.remove('active');
                }
            });
        }

        if (logoutLink) {
            logoutLink.addEventListener('click', (event) => {
                event.preventDefault();
                if (confirm("Apakah Anda yakin ingin keluar dari halaman Administrasi?")) {
                    window.location.href = "logout.php";
                }
            });
        }
    });
</script>
</body>
</html>