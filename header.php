<?php
if (!function_exists('bulan_indonesia')) {
    function bulan_indonesia($bulan_inggris) {
        $bulan = [
            'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
            'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu',
            'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
        ];
        return $bulan[$bulan_inggris] ?? $bulan_inggris;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Pura Mandira Taman Sari | Palopo'; ?></title> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css"> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header class="main-header">
    <div class="logo">
        <img src="images/2.png" alt="Logo Omkara" class="logo-om"> 
        <div class="logo-text-group">
            <span>Pura Mandira Taman Sari</span>
            <p>Kota Palopo</p>
        </div>
    </div>
    
    <button class="hamburger-menu" id="hamburgerBtn" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    
    <nav class="main-nav" id="mainNav"> 
    <ul>
        <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Beranda</a></li> 
        
        <li>
            <a href="profilpura.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'profilpura.php') ? 'active' : ''; ?>">Profil Pura</a>
        </li> 
        
        <li>
            <?php 
            $is_kegiatan_active = basename($_SERVER['PHP_SELF']) == 'detailjadwalupacara.php' || basename($_SERVER['PHP_SELF']) == 'kalender_rerainan.php';
            ?>
            <a href="index.php#kegiatan" class="<?php echo $is_kegiatan_active ? 'active' : ''; ?>"> Kegiatan </a>
        </li> 
        
        <li><a href="galeri.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'galeri.php') ? 'active' : ''; ?>">Galeri</a></li>
        
        <li>
            <?php
            $is_nilai_budaya_active = (
                basename($_SERVER['PHP_SELF']) == 'nilaibudaya.php' || 
                basename($_SERVER['PHP_SELF']) == 'tirtayatra.php' || 
                basename($_SERVER['PHP_SELF']) == 'gotongroyong.php'
            );
            ?>
            <a href="nilaibudaya.php" class="<?php echo $is_nilai_budaya_active ? 'active' : ''; ?>">Nilai Budaya</a>
        </li>
        
        <li><a href="index.php#kontak">Kontak</a></li>
        
        <li class="nav-login-item"> 
            <a href="login.php" class="btn btn-login w-100"><i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
    </ul>
</nav>
    
    <div class="auth-buttons desktop-only-login"> 
        <a href="login.php" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mainNav = document.getElementById('mainNav');
        const header = document.querySelector('.main-header');

        if (hamburgerBtn && mainNav && header) {
            hamburgerBtn.addEventListener('click', function() {
                mainNav.classList.toggle('active');
                header.classList.toggle('nav-open');
                
                var icon = this.querySelector('i');
                if (mainNav.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });

            const navLinks = mainNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 992) {
                        mainNav.classList.remove('active');
                        header.classList.remove('nav-open');
                        hamburgerBtn.querySelector('i').classList.remove('fa-times');
                        hamburgerBtn.querySelector('i').classList.add('fa-bars');
                    }
                });
            });
        }
    });
</script>