<?php
session_start();
$pageTitle = 'Detail Tirtayatra (Perjalanan Suci)';
require_once 'header.php';
?>

<style>
    .detail-item {
        background-color: #fff;
        padding: 20px; 
        border-radius: 8px;
        margin-bottom: 25px; 
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04); 
        border-left: 5px solid var(--color-primary); 
    }
    .detail-item h4 {
        color: var(--color-secondary);
        font-size: 1.6em; 
        margin-top: 0;
        padding-bottom: 8px; 
        border-bottom: 1px dashed var(--color-light-bg); 
        margin-bottom: 15px;
    }
    .detail-item ul {
        margin-top: 15px;
        padding-left: 20px;
    }
    .detail-item li {
        line-height: 1.7; 
        margin-bottom: 8px; 
    }
    .detail-content {
        padding: 5px 5% 60px 5%; 
        max-width: 1000px; 
        margin: 0 auto;
    }
    .detail-content > p { 
        font-size: 1.05em; 
        line-height: 1.8; 
        margin-bottom: 25px;
        text-align: justify;
    }
</style>

<main>
    <section class="section-title-header" style="padding: 10px 0 5px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
        <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
            Tirtayatra (Perjalanan Suci)
        </h1>
        <p style="font-size: 1.1em; color: #777; margin-top: 0; margin-bottom: 0; line-height: 1.5;">
            Perjalanan spiritual untuk penyucian diri dan memohon Tirta.
        </p>
    </section>

    <section class="detail-content">
        <p>
            Tirtayatra adalah kegiatan keagamaan yang sangat ditekankan, yaitu perjalanan suci atau ziarah ke tempat-tempat yang disucikan untuk memperdalam pengalaman spiritual umat.
        </p>

        <div class="detail-item">
            <h4><i class="fas fa-route" style="color: var(--color-primary); margin-right: 10px;"></i> Tujuan Utama Tirtayatra</h4>
            <ul>
                <li>Penyucian Diri Melepas kotoran batin dan pikiran negatif (<i>mala</i>).</li>
                <li>Memperkuat Keyakinan dengan Melihat dan merasakan langsung kekuatan spiritual di tempat-tempat suci.</li>
                <li>Memohon Tirta, Mendapatkan air suci sebagai berkah dan perlindungan.</li>
                <li>Memperluas Wawasan, Menjalin silaturahmi dengan umat dari daerah lain.</li>
            </ul>
        </div>

        <div style="text-align: center; margin-top: 50px;">
            <a href="nilaibudaya.php" class="btn" style="background-color: var(--color-secondary); color: white; padding: 12px 25px; border-radius: 20px; font-weight: 600; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Kembali 
            </a>
        </div>
    </section>

    <hr class="separator"> 
</main>

<?php
require_once 'footer.php';
?>