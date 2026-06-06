<?php

session_start();


$pageTitle = 'Detail Gotong Royong | Pura Mandira Taman Sari';

require_once 'header.php'; 
?>

<style>
    .detail-item {
        background-color: #fff;
        padding: 25px; 
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
        margin-bottom: 4px; 
    }
    
    .section-title-header {
        padding: 15px 0; 
        background-color: var(--color-light-bg); 
        text-align: center;
    }
    .section-title-header h1 {
        font-size: 2.5em; 
        margin: 0; 
        color: var(--color-secondary);
    }
    .section-title-header p {
        font-size: 1.1em; 
        color: #777;
    }
    .detail-content {
        padding: 15px 15px; 
        max-width: 900px; 
        margin: 0 auto;
    }
    .detail-content > p { 
        font-size: 1.05em; 
        line-height: 1.7; 
        margin-bottom: 30px; 
    }

    .btn-back-kegiatan {
        background-color: var(--color-secondary); 
        color: white; 
        padding: 12px 25px; 
        border-radius: 20px; 
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }
    .btn-back-kegiatan:hover {
        background-color: #dea325ff; 
        color: white;
    }

</style>

<main>
    
    <section class="section-title-header">
        <h1>GOTONG ROYONG (KERJA BAKTI)</h1>
        <p>Kegiatan kebersamaan umat untuk menjaga kebersihan dan kesucian Pura.</p>
    </section>

    <div class="container">
        <section class="detail-content">
            <p>
                Gotong Royong atau kerja bakti merupakan salah satu wujud nyata implementasi nilai Tri Hita Karana, khususnya dalam menjaga keharmonisan dengan alam dan lingkungan suci (Palemahan). Kegiatan ini wajib dilaksanakan oleh seluruh umat sebagai bentuk tanggung jawab kolektif terhadap tempat pemujaan.
                 Kegiatan ini tidak hanya sekadar membersihkan fisik Pura, tetapi juga mempererat tali persaudaraan (Pasemetonan) antar umat. Dengan bekerja bersama, umat dapat:
                    Mengembangkan rasa kepemilikan dan tanggung jawab bersama.
                    Melatih sikap ikhlas (Yadnya) dalam pengabdian.
                    Menciptakan suasana Pura yang bersih, indah, dan nyaman untuk bersembahyang.
            </p>
            
            <div style="text-align: center; margin-top: 10px;">
                <a href="nilaibudaya.php" class="btn-back-kegiatan">
                    <i class="fas fa-arrow-left"></i> Kembali 
                </a>
            </div>

        </section>
    </div>
    
    <hr class="separator"> 

</main>

<?php
require_once 'footer.php'; 
?>