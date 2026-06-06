<?php
session_start();

require_once 'koneksi.php'; 

$pageTitle = 'Tentang Pura Mandira Taman Sari';

require_once 'header.php'; 
?>

<style>
  
    .vision-mission-container {
        display: flex; 
        gap: 30px; 
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .vision-mission-container > div {
        flex: 1; 
        min-width: 300px;
        border-left: 5px solid var(--color-primary, #a86c38); 
        padding-left: 20px;
        margin-bottom: 20px;
    }

    .cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
        margin-top: 20px;
    }
    .value-card {
        flex-basis: 30%;
        min-width: 280px;
        text-align: center;
        padding: 30px 20px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .card-icon {
        font-size: 2.5em;
        color: var(--color-primary, #a86c38);
        margin-bottom: 10px;
        display: block;
    }

    @media (max-width: 768px) {
        .value-card {
            flex-basis: 100%;
            max-width: none;
        }
    }
</style>

<main>
    <section class="section-title-header" style="padding: 15px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
        <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
            Profil Pura Mandira Taman Sari 
        </h1>
        <p style="font-size: 1.1em; color: #777; margin-top: 0; line-height: 1.5;">
            Informasi mengenai Pura, kepengurusan, dan peranannya.
        </p>
    </section>

    <section class="detail-content" style="padding: 20px 5% 60px 5%; max-width: 1000px; margin: 0 auto;">
        
        <div class="content-block">
        <h2 style="color: var(--color-primary, #a86c38); border-bottom: 2px solid var(--color-light-bg, #f4f4f9); padding-bottom: 10px; margin-bottom: 20px; margin-top: 0;">Sejarah Singkat Pura</h2>   
            <p style="text-align: justify; line-height: 1.8;">
                Pura Mandira Taman Sari memiliki perjalanan sejarah yang cukup panjang di Kota Palopo. Keberadaan tempat suci ini sebenarnya sudah ada sejak tahun 1980-an, di mana pada masa itu bangunan pura masih sangat sederhana dan berfungsi sebagai pusat peribadatan awal bagi umat Hindu yang menetap di wilayah tersebut Meskipun kondisinya saat itu belum semegah sekarang.
                <br><br>
                Seiring berjalannya waktu dan melihat jumlah umat yang terus bertambah, muncul keinginan bersama untuk memiliki sarana ibadah yang lebih layak dan permanen. Langkah besar tersebut akhirnya terealisasi saat pembangunan permanen mulai dilaksanakan pada tanggal 23 Desember 2007. Proses pembangunan ini dilakukan secara bertahap hingga akhirnya bangunan pura berdiri kokoh dan diresmikan secara resmi pada tanggal 9 April 2009.
                 <br><br> Hingga saat ini, Pura Mandira Taman Sari melayani sekitar 800 orang umat Hindu yang berdomisili di Kota Palopo dan sekitarnya. Selain menjadi tempat utama untuk melaksanakan persembahyangan rutin dan upacara hari besar keagamaan, pura ini juga memegang peranan penting sebagai ruang edukasi budaya dan tempat mempererat ikatan persaudaraan antarumat. Keberadaan pura ini menjadi bukti nyata pelestarian nilai-nilai luhur dan keharmonisan hidup bermasyarakat di Kota Palopo.
        </p>
        </div>
        <div class="separator" style="border-top: 1px solid #ddd; margin: 40px 0;"></div>

        <div class="content-block">
            <h2 style="color: var(--color-secondary, #333); border-bottom: 2px solid var(--color-light-bg, #f4f4f9); padding-bottom: 10px; margin-bottom: 20px;">Visi dan Misi</h2>
            <div class="vision-mission-container">
                <div>
                    <h3 style="font-family: 'Poppins', sans-serif; margin-top: 0; color: var(--color-primary, #a86c38);"><i class="fas fa-eye" style="margin-right: 8px;"></i> Visi</h3>
                    <p style="line-height: 1.6;">
                       Menjadi pusat spiritualitas dan budaya Hindu yang harmonis di Kota Palopo, guna melestarikan nilai-nilai luhur agama demi terwujudnya umat yang religius, beretika, dan berwawasan luas.
                    </p>
                </div>
                <div>
                   <h3 style="font-family: 'Poppins', sans-serif; margin-top: 0; color: var(--color-primary, #a86c38);"><i class="fas fa-bullseye" style="margin-right: 8px;"></i> Misi</h3>
                <ol style="list-style-type: decimal; margin-left: 20px; font-size: 1em; line-height: 1.6; padding-left: 15px;">
                    <li style="margin-bottom: 10px;">Menjadi wadah untuk menjaga dan memperkenalkan tradisi serta nilai-nilai budaya Hindu kepada generasi muda dan masyarakat luas.</li>
                    <li style="margin-bottom: 10px;"> Menyediakan akses informasi keagamaan dan jadwal kegiatan yang akurat serta mudah diakses oleh umat melalui sistem informasi berbasis web.</li>
                    <li style="margin-bottom: 10px;"> Menanamkan ajaran Tri Hita Karana dan Tat Twam Asi dalam kehidupan sehari-hari untuk menciptakan keharmonisan dengan sesama dan alam sekitar.</li>
                </ol>
                    </ul>
                </div>
            </div>
        </div>

        <div class="separator" style="border-top: 1px solid #ddd; margin: 40px 0;"></div>

        <div class="content-block">
            <center>
                <h2 style="color: var(--color-primary, #a86c38); border-bottom: 2px solid var(--color-light-bg, #f4f4f9); padding-bottom: 10px; margin-bottom: 20px;">
                    Struktur Kepengurusan Pura
                </h2>
            </center>
            <p style="text-align: center; margin-bottom: 30px; color: #666;">
                Berikut adalah susunan Pengurus Pura Mandira Taman Sari periode 2024 - 2029.
            </p>

            <div class="cards" style="flex-wrap: nowrap; align-items: stretch;">
    <div class="value-card" style="flex: 1; min-width: 0; max-width: none;">
        <span class="card-icon"><i class="fas fa-user-tie"></i></span>
        <h3 style="color: var(--color-secondary, #333); margin-top: 0; font-family: 'Poppins', sans-serif;">Ketua Pengurus</h3>
        <p style="margin-bottom: 5px; color: #000;">Made Pandya</p>
    </div>

    <div class="value-card" style="flex: 1; min-width: 0; max-width: none;">
        <span class="card-icon"><i class="fas fa-file-alt"></i></span>
        <h3 style="color: var(--color-secondary, #333); margin-top: 0; font-family: 'Poppins', sans-serif;">Sekretaris</h3>
        <p style="margin-bottom: 5px;  color: #333;">Komang Suartha</p>
    </div>

    <div class="value-card" style="flex: 1; min-width: 0; max-width: none;">
        <span class="card-icon"><i class="fas fa-wallet"></i></span>
        <h3 style="color: var(--color-secondary, #333); margin-top: 0; font-family: 'Poppins', sans-serif;">Bendahara</h3>
        <p style="margin-bottom: 5px;  color: #333;">Made Sudarta</p>
    </div>
</div>
        
    </section>
</main>

<?php

require_once 'footer.php'; 
?>