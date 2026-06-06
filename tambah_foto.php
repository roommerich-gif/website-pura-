<?php
session_start();
require_once "koneksi.php";

$pageTitle = "Tambah Foto Galeri";

$success_message = "";
$error_message = "";

if (isset($_POST['upload'])) {

    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);

    if (empty($judul) || empty($deskripsi)) {
        $error_message = "Semua field wajib diisi.";
    } elseif (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
        $error_message = "Silakan pilih foto yang valid.";
    } else {

        $foto = $_FILES['foto'];
        $allowed_ext = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_ext)) {
            $error_message = "Format foto harus JPG / JPEG / PNG.";
        } elseif ($foto['size'] > 4 * 1024 * 1024) {
            $error_message = "Ukuran foto maksimal 4 MB.";
        } else {

            $safe_judul = preg_replace('/[^a-zA-Z0-9-]/', '_', $judul);
            $nama_file = $safe_judul . "_".time()."_".rand(100,999).".".$ext;

            $folder = "uploads/galeri/";
            $path_simpan = $folder . $nama_file;

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            if (move_uploaded_file($foto['tmp_name'], $path_simpan)) {

                $stmt = $conn->prepare("
                    INSERT INTO galeri (judul_foto, deskripsi, path_file)
                    VALUES (?, ?, ?)
                ");
                $stmt->bind_param("sss", $judul, $deskripsi, $path_simpan);

                if ($stmt->execute()) {
                
                    $_SESSION['success_message'] = "Foto **" . htmlspecialchars($judul) . "** berhasil diunggah!";
                    header("Location: kelola_galeri.php");
                    exit;
                } else {
                    $error_message = "Gagal menyimpan ke database.";
                }
                $stmt->close();

            } else {
                $error_message = "Gagal mengupload file.";
            }
        }
    }
} 

if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $success_message = "Foto berhasil diunggah!";
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
       
        .alert-error,
        .alert-sukses {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .alert-error {
            background: #ffdddd;
            color: #b10000;
            border: 1px solid #ffb5b5;
        }

        .alert-sukses {
            background: #ddffea;
            color: #008c45;
            border: 1px solid #9ff3c7;
        }

     
        #previewImage {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
            margin-bottom: 15px; 
        }

        .btn-upload {
            background: #e6b13eff;
            border: none;
            color: #fff;
            padding: 10px 20px; 
            border-radius: 8px;
            font-size: 1.0em;
            font-weight: 600;
            transition: 0.2s;
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .btn-upload:hover {
            background: #c89a32;
            color: #fff;
        }
  
        .admin-content-col {
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }
        .content-wrapper {
            flex: 1; 
            padding-bottom: 20px;
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
                <a href="adminpura.php#kegiatan-admin">
                    <i class="fas fa-calendar-alt me-2"></i> Kelola Jadwal Upacara
                </a>
                <a href="kelola_galeri.php" class="active">
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
            
            <div class="content-wrapper">
                <div class="content-header-mobile d-flex justify-content-start align-items-center mb-4 d-lg-none">
                    <button class="admin-hamburger-toggle me-3" id="adminMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0"><?php echo $pageTitle; ?></h1>
                </div>
                
                <h1 class="mb-4 d-none d-lg-block text-center"><?php echo $pageTitle; ?></h1>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow">
                                <div class="card-header bg-warning text-white text-center">
                                    <h3 class="mb-0"><i class="fas fa-upload me-2"></i> Form Unggah Foto Baru</h3>
                                </div>
                                <div class="card-body">
                                    
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert-error">❌ <?= $error_message ?></div>
                                    <?php endif; ?>
                                    
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul Foto</label>
                                            <input type="text" class="form-control" id="judul" name="judul" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="imgInput" class="form-label">Pilih Foto (Max 4MB, JPG/PNG)</label>
                                            <input type="file" class="form-control" id="imgInput" name="foto" accept="image/*" required>
                                        </div>
                                        
                                        <img id="previewImage" style="display:none;">

                                        <div class="row justify-content-center mt-4">
                                            <div class="col-lg-6 col-md-8 col-10 d-grid">
                                                <button type="submit" name="upload" class="btn-upload">
                                                    <i class="fas fa-upload"></i> Unggah Foto
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="admin-footer text-center py-3 border-top">
                <p class="text-muted small mb-0">© <?php echo date("Y"); ?> Dashboard Pura Mandira Taman Sari.</p>
            </footer>

        </div>
    </div> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.getElementById("imgInput").addEventListener("change", function(){
        let file = this.files[0];
        let img = document.getElementById("previewImage"); 
        
        if(!file) {
            img.src = "";
            img.style.display = "none";
            return;
        }
        
        let reader = new FileReader();
        reader.onload = function(e){
            img.src = e.target.result;
            img.style.display = "block";
        }
        reader.readAsDataURL(file);
    });
    </script>
    
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