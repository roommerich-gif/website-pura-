<?php
session_start();

$pageTitle = 'Kalender Rerainan Pura';
require_once 'header.php'; 
?>

<style>
    .calendar-container {
        max-width: 1100px; 
        margin: 0 auto;
        padding: 0 5%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
        border-radius: 10px;
        overflow: hidden; 
        background-color: white;
    }

    .calendar-container iframe {
        width: 100%; 
        height: 900px; 
        border: none;
        display: block;
    }
</style>

<main>
    <section class="section-title-header" style="padding: 50px 0; background-color: var(--color-light-bg); text-align: center;">
        <h1 style="font-size: 3em; margin: 0; color: var(--color-secondary);">KALENDER RERAINAN HINDU</h1>
        <p style="font-size: 1.2em; color: #777;">Jadwal hari raya dan hari suci disajikan secara dinamis.</p>
    </section>

    <section class="detail-content" style="padding: 60px 0 80px 0;">
        
        <div style="text-align: center; margin-bottom: 30px; padding: 0 5%;">
            <p style="font-size: 1.1em; color: #555;">Data ini bersumber dari Kalender Bali Digital (kalenderbali.org) dan diupdate secara otomatis.</p>
        </div>
        
        <div class="calendar-container">
            <iframe 
                src="https://kalenderbali.org/" 
                width="100%" 
                height="900" 
                frameborder="0"
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="index.php#kegiatan" 
                class="btn" 
                style="background-color: var(--color-secondary); 
                       color: white; 
                       padding: 12px 25px; 
                       border-radius: 20px; 
                       font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama
            </a>
        </div>

    </section>
</main>

<?php
require_once 'footer.php'; 
?>