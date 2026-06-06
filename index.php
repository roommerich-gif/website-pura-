<?php
require_once 'koneksi.php'; 

$pageTitle = "Beranda | Pura Mandira Taman Sari"; 
 
require_once 'header.php'; 
?>
    
    <main class="home-main">
        
    <section class="hero-section">
        
        <div class="pura-bg-wrapper">
            <img src="images/puraa.png" alt="Latar Belakang Pura Mandira Taman Sari" class="pura-bg-img">
            
            <div class="pura-overlay"></div>
        </div>

        <div class="content-container">
            <div class="om-symbol"></div>
            <h1>PURA MANDIRA TAMAN SARI</h1>
            <h2>MENJAGA SPIRITUAL & BUDAYA HINDU PALOPO</h2>
            <a href="#kegiatan" class="btn btn-dashboard">
                <i class="fas fa-calendar-alt"></i> Lihat Jadwal Upacara
            </a>
        </div>
    </section>

    <section id="profilpura" class="about container my-5">
    <div class="pura-hero">
        <img src="images/backdrop.png" alt="Latar Belakang Pura Mandira Taman Sari" class="pura-bg-img">
        <div class="pura-overlay"></div>
        <div class="pura-content">
            <h2 class="section-title">Profil Pura</h2>
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <p class="about-text">Pura Mandira Taman Sari merupakan pusat kegiatan keagamaan umat Hindu di Kota Palopo. Tempat ini menjadi sarana persembahyangan dan pelestarian nilai-nilai luhur.</p>
                    <a href="profilpura.php" class="btn btn-detail">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</section>

        <hr class="separator">

        <section id="kegiatan" class="event-dashboard-section container my-5">
            <div class="pura-hero">
                <div class="pura-overlay"></div>
                <div class="pura-content">
                    <h2 class="section-title">Jadwal Upacara & Kegiatan Mendatang</h2>
                    <p class="section-subtitle" style="color:#5e3b0c;">Dapatkan informasi jadwal persembahyangan dan upacara dengan akurat dan cepat.</p>
                    
                    <div class="events-list-container">
                        
                        <?php
                      
                        $sql = "SELECT id_kegiatan, judul, tanggal, waktu, lokasi, deskripsi_singkat 
                                     FROM jadwal_upacara 
                                     WHERE 1
                                     ORDER BY tanggal ASC 
                                     ";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                  
                                $tanggal_obj = new DateTime($row['tanggal']); 
                        ?>
                        
                        <div class="event-item">
                            <div class="event-date">
                                <span class="day"><?php echo $tanggal_obj->format('d'); ?></span>
                                <span class="month"><?php echo bulan_indonesia($tanggal_obj->format('M')); ?></span>
                            </div>
                            <div class="event-details">
                                <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
                                <p><?php echo htmlspecialchars($row['deskripsi_singkat']); ?></p>
                                <span class="event-location">
                                    <i class="fas fa-clock"></i> Pukul <?php echo date('H:i', strtotime($row['waktu'])); ?> WITA | 
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['lokasi']); ?>
                                </span>
                            </div>
                            <a href="detailjadwalupacara.php?id=<?= $row['id_kegiatan'] ?>" class="btn btn-detail"> Detail</a>
                        </div>
                        <?php
                            endwhile;
                        else:
                            echo "<center> <p class='text-center text-muted p-4'>Tidak ada jadwal upacara yang akan datang.</p>";
                        endif;
                        ?>

                    </div>
                    
                    <div class="full-calendar-link mt-4 text-center">
                        <a href="kalender_rerainan.php"><i class="fas fa-calendar"></i> Lihat Kalender Rerainan Seluruhnya</a>
                    </div>
                </div>
            </div>
        </section>

        <hr class="separator">
        
        <section id="galeri" class="events container my-5">
            <div class="pura-hero">
                <div class="pura-overlay"></div>
                <div class="pura-content">
                    <h2 class="section-title">Galeri Kegiatan</h2>
                    <p class="section-subtitle" style="color:#5e3b0c;">Dokumentasi kegiatan dan upacara sebagai arsip digital dan pelestarian budaya.</p>

                    <div class="row cards">
                        <?php
                        
                        $result = $conn->query("SELECT * FROM galeri ORDER BY id_foto DESC LIMIT 3");
                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                            <div class="col-12 col-md-4 mb-4">
                                <div class="card event-card">
                                    <div class="img-container">
                                        <img src="<?= htmlspecialchars($row['path_file']) ?>" 
                                             alt="<?= htmlspecialchars($row['judul_foto']) ?>">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?= htmlspecialchars($row['judul_foto']) ?></h3>
                                        <p class="card-text"><?= htmlspecialchars($row['deskripsi']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php           
                            endwhile;
                        else:
                        ?>
                            <div class="col-12 text-center">
                                <p style="color:#888; font-style:italic;">Belum ada foto di galeri.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="galeri.php" class="btn-selengkapnya">
                            <i class="fas fa-images"></i> Lihat Seluruh Album Foto/Video
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <hr class="separator">

        <section id="nilai" class="values container my-5">
            <div class="pura-hero">
                <div class="pura-overlay"></div>
                <div class="pura-content">
                    <h2 class="section-title">Nilai Budaya Hindu</h2>
                    <p class="section-subtitle" style="color:#5e3b0c;">Pilar-pilar filosofis yang menjadi landasan kehidupan beragama dan sosial umat Hindu.</p>
                    
                    <div class="row cards">
                        
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card value-card">
                                <h3 class="card-title">Tri Hita Karana</h3>
                                <p class="card-text">Menjaga keseimbangan hubungan manusia dengan Tuhan, sesama, dan alam.</p>
                                <a href="trihitakarana.php" class="btn-link mt-3 d-inline-block">Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card value-card">
                                <h3 class="card-title">Tat Twam Asi</h3>
                                <p class="card-text">Kesadaran bahwa semua makhluk adalah satu. "Aku adalah Kamu, Kamu adalah Aku."</p>
                                <a href="tattwamasi.php" class="btn-link mt-3 d-inline-block"> Baca Selengkapnya
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 mb-4">
                            <div class="card value-card">
                                <h3 class="card-title">Gotong Royong</h3>
                                <p class="card-text">Tradisi kebersamaan umat dalam pelaksanaan ngayah dan upacara.</p>
                                <a href="gottongroyong.php" class="btn-link mt-3 d-inline-block"> Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="full-calendar-link mt-4 text-center">
                        <a href="nilaibudaya.php"> Pelajari Nilai Lainnya</a>
                    </div>
                </div>
            </div>
        </section> 
        <hr class="separator">

        <section id="kontak" class="contact-section container my-5">
            <div class="pura-hero">
                <div class="pura-overlay"></div>
                <div class="pura-content">
                    <h3 class="section-title">Lokasi dan Kontak Kami</h3>
                    
                    <div class="row contact-grid"> 
                        
                        <div class="col-md-6 mb-4">
                            <div class="contact-map h-100"> 
                                
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.223406385311!2d120.19835707474404!3d-3.00392659695697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d908269d0449d03%3A0xc3f7a7751910609b!2sPura%20Mandira%20Taman%20Sari!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="contact-details">
                                <h3 class="contact-title">Hubungi Kami</h3>
                                <p class="contact-info"><i class="fas fa-map-marker-alt"></i>  Jalan Bangau Permata Hijau, Kelurahan Temmalebba, Kecamatan Bara, Kota Palopo, Sulawesi Selatan</p>
                                <p class="contact-info"><i class="fas fa-envelope"></i> puramandiratamansarikotapalopo@gmail.com</p>
                                <p class="contact-info"><i class="fas fa-phone"></i> 081241336488</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

<?php

require_once 'footer.php'; 
?>