<footer class="main-footer">
        <div class="footer-content container">
            <div class="row">
                <div class="col-12 col-md-4 footer-section footer-brand mb-4">
                    <div class="logo d-flex align-items-start">
                        <img src="images/2.png" alt="Logo Om Footer" class="logo-om" style="width: 50px; margin-right: 15px;"> 
                        <div class="logo-text-group">
                            <span style="display: block; font-weight: bold; font-size: 1.2rem;">Pura Mandira Taman Sari</span>
                            <p style="margin-bottom: 10px;">Kota Palopo</p>
                            
                            <p class="alamat-footer" style="font-size: 0.9rem; line-height: 1.5; margin: 0; max-width: 300px;">
                                Jalan Bangau Permata Hijau, Kelurahan Temmalebba, Kecamatan Bara, <br>
                                Kota Palopo, Sulawesi Selatan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-2 offset-md-1 footer-section mb-4">
                    <h4 style="margin-top: 0;">Informasi Pura</h4>
                    <ul class="list-unstyled">
                        <li><a href="index.php#profil">Sejarah Pura</a></li>
                        <li><a href="#">Struktur Kepengurusan</a></li>
                        <li><a href="index.php#galeri">Galeri Kegiatan</a></li>
                        <li><a href="index.php#kontak">Peta & Lokasi</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2 footer-section mb-4">
                    <h4 style="margin-top: 0;">Kegiatan & Upacara</h4>
                    <ul class="list-unstyled">
                    <?php    
                    if (isset($conn)) {
                        $query_kegiatan = "SELECT judul FROM jadwal_upacara ORDER BY tanggal DESC LIMIT 3";
                        $result_kegiatan = mysqli_query($conn, $query_kegiatan);

                        if ($result_kegiatan && mysqli_num_rows($result_kegiatan) > 0) {
                            while($row = mysqli_fetch_assoc($result_kegiatan)) {
                                echo '<li><a href="index.php#kegiatan">' . htmlspecialchars($row['judul']) . '</a></li>';
                            }
                        } else {
                            echo '<li>Belum ada jadwal</li>';
                        }
                    }
                    ?>
                    </ul>
                </div>

                <div class="col-12 col-md-3 footer-section mb-4">
                    <h4 style="margin-top: 0;">Edukasi Nilai Budaya</h4>
                    <ul class="list-unstyled">
                        <li><a href="trihitakarana.php">Tri Hita Karana</a></li>
                        <li><a href="tattwamasi.php">Tat Twam Asi</a></li>
                        <li><a href="gottongroyong.php">Gotong Royong</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom" style="text-align: center; padding: 20px 0; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© <?php echo date("Y"); ?> Pura Mandira Taman Sari | Kota Palopo</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>