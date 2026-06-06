<?php
session_start();
$pageTitle = 'Detail Tat Twam Asi';

require_once 'header.php'; 
?>

<style>
    .detail-item {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 20px; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--color-primary);
    }
    .detail-item h4 {
        color: var(--color-secondary);
        font-size: 1.8em;
        margin-top: 0;
        margin-bottom: 10px; 
        padding-bottom: 5px;
        border-bottom: 1px dashed var(--color-light-bg);
    }

    .detail-item p:first-of-type {
        margin-top: 0;
    }

    .detail-content ul {
        padding-left: 20px;
        list-style-type: disc;
    }
    .detail-content li {
        margin-bottom: 8px;
        line-height: 1.6;
    }
    
    .detail-content {
        padding: 15px 5% 60px 5%; 
        max-width: 1000px; 
        margin: 0 auto;
    }

    .intro-paragraph {
        font-size: 1.1em;
        line-height: 2.0;
        margin-top: 0;
        margin-bottom: 20px;
    }
</style>

<main>
    <section class="section-title-header" style="padding: 15px 0 5px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
        <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
            Tat Twam Asi
        </h1>
        <p style="font-size: 1.1em; color: #777; margin-top: 0; margin-bottom: 0; line-height: 1.5;">
            Prinsip Kesamaan Jiwa dan Kasih Sayang Universal.
        </p>
    </section>

    <section class="detail-content">
        <p class="intro-paragraph">
            Tat Twam Asi adalah ajaran moral dan etika sosial yang sangat mendalam, yang berasal dari kitab Upanishad. Secara harfiah berarti "Engkau adalah Aku, Aku adalah Engkau". Ajaran ini menegaskan bahwa esensi terdalam dari diri setiap makhluk (Atman) adalah sama, dan Atman adalah bagian dari Brahman (Tuhan).
        </p>

        <div class="detail-item">
            <h4><i class="fas fa-hand-holding-heart" style="color: var(--color-primary); margin-right: 10px;"></i> Inti Ajaran: Persamaan Atman</h4>
            <p>
                Karena Atman yang bersemayam dalam diri Anda sama dengan Atman yang bersemayam dalam diri orang lain (dan semua makhluk), maka menyakiti orang lain sama dengan menyakiti diri sendiri. Hal ini menjadi landasan untuk sikap welas asih (karuna) dan persaudaraan sejati.
            </p>
        </div>

        <div class="detail-item">
            <h4><i class="fas fa-crosshairs" style="color: var(--color-primary); margin-right: 10px;"></i> Manifestasi dalam Kehidupan Sehari-hari</h4>
            <p>
                Ajaran Tat Twam Asi diwujudkan dalam tindakan nyata seperti:
            </p>
            <ul>
                <li>Gotong Royong: Bekerja sama tanpa mengharapkan imbalan.</li>
                <li>Tolong-menolong: Memberikan bantuan kepada siapa pun yang membutuhkan.</li>
                <li>Toleransi:Menghargai perbedaan, karena semua memiliki esensi yang sama.</li>
            </ul>
            <p>
                Bagi umat Pura Mandira Taman Sari, prinsip ini adalah pendorong utama dalam menjaga kerukunan dan keharmonisan di Palopo.
            </p>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="nilaibudaya.php" class="btn" style="background-color: var(--color-secondary); color: white; padding: 12px 25px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Kembali 
            </a>
        </div>

    </section>
    
    <hr class="separator"> 

</main>

<?php
require_once 'footer.php'; 
?>