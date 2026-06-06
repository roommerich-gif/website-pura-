<?php
session_start();

require_once 'koneksi.php'; 

$pageTitle = "Daftar Lengkap Nilai Hindu | Pura Mandira Taman Sari"; 

require_once 'header.php'; 
?>

<main>

    <section class="section-title-header" style="padding: 15px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
        <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
            Nilai Dan Budaya Hindu
        </h1>
        <p style="font-size: 1.1em; color: #777; margin-top: 0; line-height: 1.5;">
            Landasan etika, spiritual, dan filosofi kehidupan umat Hindu.
        </p>
    </section>
    
    <style>
       
        .nilai-card-highlight {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 40px;
            border-left: 5px solid var(--color-primary); 
        }
        
        .nilai-section-title {
            color: var(--color-secondary);
            font-family: 'Playfair Display', serif;
            font-size: 2.2em;
            margin-top: 30px; 
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-primary);
        }

        .nilai-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .nilai-list-table th, .nilai-list-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .nilai-list-table th {
            background-color: var(--color-light-bg);
            color: var(--color-secondary);
            font-weight: 600;
        }

        .nilai-list-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .nilai-sanskerta {
            font-weight: 600;
            color: var(--color-primary);
        }
    </style>

    <section class="detail-content container" style="padding: 0px 0 30px 0; max-width: 1100px; margin: 0 auto;">
        
        <h3 class="nilai-section-title"><i class="fas fa-dharmachakra" style="color: var(--color-primary); margin-right: 10px;"></i> Nilai-Nilai Fundamental Filosofis</h3>
        <table class="nilai-list-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Nilai</th>
                    <th style="width: 40%;">Keterangan</th>
                    <th style="width: 40%;">Relevansi Spiritual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="nilai-sanskerta">Dharma</td>
                    <td>Prinsip kebenaran, hukum kosmis, keadilan, dan kewajiban moral.</td>
                    <td>Bertindak benar, jujur, dan bertanggung jawab.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Karma</td>
                    <td>Hukum sebab-akibat (aksi-reaksi). Setiap perbuatan menghasilkan konsekuensi.</td>
                    <td>Mendorong umat untuk berbuat baik dan menghindari perbuatan buruk.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Moksha</td>
                    <td>Tujuan tertinggi hidup, yaitu pembebasan dari siklus kelahiran dan penyatuan dengan Tuhan (Brahman).</td>
                    <td>Mendorong praktik spiritual dan hidup damai.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Puruṣārtha</td>
                    <td>Empat tujuan hidup: Dharma, Artha (kekayaan wajar), Kama (keinginan sehat), dan Moksha.</td>
                    <td>Menyeimbangkan kehidupan duniawi dan spiritual.</td>
                </tr>
            </tbody>
        </table>

        <h3 class="nilai-section-title"><i class="fas fa-globe-asia" style="color: var(--color-primary); margin-right: 10px;"></i> Nilai-Nilai Sosial dan Universal</h3>
        <table class="nilai-list-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Nilai (Sanskerta)</th>
                    <th style="width: 40%;">Makna</th>
                    <th style="width: 40%;">Relevansi Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="nilai-sanskerta">Vasudhaiva Kuṭumbakam</td>
                    <td>"Dunia adalah Satu Keluarga." Prinsip kesatuan dan persaudaraan universal.</td>
                    <td>Toleransi antar umat beragama, menghargai keberagaman, dan menjaga kerukunan global.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Tattwa Susila</td>
                    <td>Etika dan moralitas; pedoman perilaku yang baik.</td>
                    <td>Menjaga integritas di tempat kerja, beretika dalam bermedia sosial, dan menjauhi korupsi.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Maitrī & Karuṇā</td>
                    <td>Maitri (Cinta kasih persahabatan) dan Karuna (Belas kasih terhadap penderitaan).</td>
                    <td>Mendorong aksi sosial, kepedulian lingkungan, dan bantuan kemanusiaan.</td>
                </tr>
                <tr>
                    <td class="nilai-sanskerta">Jagadhita</td>
                    <td>Kesejahteraan dunia, menciptakan kedamaian dan kemakmuran bagi semua.</td>
                    <td>Mendukung pembangunan berkelanjutan dan berkontribusi pada kemajuan masyarakat secara umum.</td>
                </tr>
            </tbody>
        </table>

        <h3 class="nilai-section-title"><i class="fas fa-hands-praying" style="color: var(--color-primary); margin-right: 10px;"></i>Panca Sradha (Lima Dasar Keyakinan)</h3>
        <table class="nilai-list-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Keyakinan</th>
                    <th style="width: 40%;">Makna</th>
                    <th style="width: 40%;">Implementasi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="nilai-sanskerta">Brahman</td><td>Percaya kepada Tuhan Yang Maha Esa (Ida Sang Hyang Widhi Wasa).</td><td>Melakukan persembahan dan sembahyang (Bhakti).</td></tr>
                <tr><td class="nilai-sanskerta">Ātman</td><td>Percaya kepada adanya jiwa abadi dalam setiap makhluk hidup.</td><td>Menghormati semua bentuk kehidupan dan diri sendiri.</td></tr>
                <tr><td class="nilai-sanskerta">Karma Phala</td><td>Percaya kepada hukum sebab-akibat (Karma) dan hasilnya (Phala).</td><td>Bertindak dengan kesadaran penuh, menghindari kejahatan.</td></tr>
                <tr><td class="nilai-sanskerta">Saṁsāra</td><td>Percaya kepada reinkarnasi (punarbhawa) atau kelahiran kembali.</td><td>Berusaha meningkatkan kualitas hidup dan spiritual.</td></tr>
                <tr><td class="nilai-sanskerta">Moksha</td><td>Percaya kepada kebebasan tertinggi (penyatuan Atman dengan Brahman).</td><td>Menjalankan Dharma untuk mencapai tujuan hidup tertinggi.</td></tr>
            </tbody>
        </table>
        
        <h3 class="nilai-section-title"><i class="fas fa-route" style="color: var(--color-primary); margin-right: 10px;"></i> Catur Marga (Empat Jalan Yoga)</h3>
        <table class="nilai-list-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Marga (Jalan)</th>
                    <th style="width: 40%;">Fokus</th>
                    <th style="width: 40%;">Deskripsi Singkat</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="nilai-sanskerta">Bhakti Marga</td><td>Cinta Kasih dan Pengabdian</td><td>Jalan mencapai Tuhan melalui cinta kasih, pengabdian, dan ritual keagamaan yang tulus (Bhakti).</td></tr>
                <tr><td class="nilai-sanskerta">Karma Marga</td><td>Perbuatan Tanpa Pamrih</td><td>Jalan mencapai Tuhan melalui pekerjaan atau tindakan yang dilakukan tanpa terikat pada hasil atau pamrih (seva).</td></tr>
                <tr><td class="nilai-sanskerta">Jñāna Marga</td><td>Pengetahuan dan Kebijaksanaan</td><td>Jalan mencapai Tuhan melalui ilmu pengetahuan spiritual dan perenungan filosofis untuk mengenal hakikat Atman dan Brahman.</td></tr>
                <tr><td class="nilai-sanskerta">Raja Marga</td><td>Meditasi dan Pengendalian Diri</td><td>Jalan mencapai Tuhan melalui yoga, meditasi, dan pengendalian indria (Astanga Yoga).</td></tr>
            </tbody>
        </table>

        <h2 class="nilai-section-title"><i class="fas fa-hand-sparkles" style="color: var(--color-primary); margin-right: 10px;"></i> Nilai-Nilai Etika dan Moral (Yama & Niyama)</h2>
        <table class="nilai-list-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Nilai (Sanskerta)</th>
                    <th style="width: 30%;">Kategori</th>
                    <th style="width: 50%;">Makna</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="nilai-sanskerta">Ahimsa</td><td>Etika Sosial</td><td>Non-kekerasan dalam pikiran, ucapan, dan perbuatan.</td></tr>
                <tr><td class="nilai-sanskerta">Satya</td><td>Etika Sosial</td><td>Kejujuran dan kebenaran dalam perkataan.</td></tr>
                <tr><td class="nilai-sanskerta">Asteya</td><td>Etika Sosial</td><td>Tidak mencuri atau mengambil yang bukan haknya.</td></tr>
                <tr><td class="nilai-sanskerta">Sauca</td><td>Disiplin Diri</td><td>Kesucian, kebersihan lahir dan batin.</td></tr>
                <tr><td class="nilai-sanskerta">Santosha</td><td>Disiplin Diri</td><td>Kepuasan atau rasa syukur (menerima apa adanya).</td></tr>
                <tr><td class="nilai-sanskerta">Tapas</td><td>Disiplin Diri</td><td>Pengendalian diri dan kesadaran diri.</td></tr>
                <tr><td class="nilai-sanskerta">Brahmacarya</td><td>Etika Sosial</td><td>Pengendalian diri dari nafsu birahi.</td></tr>
                <tr><td class="nilai-sanskerta">Aparigraha</td><td>Etika Sosial</td><td>Tidak serakah, tidak menimbun harta berlebihan.</td></tr>
                <tr><td class="nilai-sanskerta">Swadhyaya</td><td>Disiplin Diri</td><td>Belajar kitab suci dan introspeksi diri.</td></tr>
                <tr><td class="nilai-sanskerta">Īśvarapranidhāna</td><td>Disiplin Diri</td><td>Penyerahan diri sepenuhnya kepada Tuhan.</td></tr>
            </tbody>
        </table>

        <h2 class="nilai-section-title"><i class="fas fa-place-of-worship" style="color: var(--color-primary); margin-right: 10px;"></i> Nilai dan Budaya Khusus Pura</h2>
        
        <div class="nilai-card-highlight">
            <h3>Tri Hita Karana</h3>
            <p>Konsep tiga penyebab kebahagiaan: hubungan harmonis dengan Tuhan (Parhyangan), manusia (Pawongan), dan alam (Palemahan).</p>
            <div style="text-align: right; margin-top: 15px;">
                <a href="trihitakarana.php" class="btn" style="background-color: var(--color-primary); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="nilai-card-highlight">
            <h3>Tat Twam Asi</h3>
            <p>Semboyan moral "Engkau adalah Aku, Aku adalah Engkau," yang mengajarkan prinsip kesamaan jiwa dan empati universal.</p>
            <div style="text-align: right; margin-top: 15px;">
                <a href="tattwamasi.php" class="btn" style="background-color: var(--color-primary); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="nilai-card-highlight">
            <h3>Gotong Royong </h3>
            <p>Kerja bakti sukarela sebagai pengabdian suci dan landasan etika moral (Tattwa Susila) dalam perilaku sehari-hari.</p>
            <div style="text-align: right; margin-top: 15px;">
                <a href="gottongroyong.php" class="btn" style="background-color: var(--color-primary); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="nilai-card-highlight">
            <h3>Yadnya (Persembahan Suci)</h3>
            <p>Pengorbanan suci yang dilakukan secara tulus ikhlas (bhakti) sebagai wujud syukur dan bakti kepada Tuhan dan alam semesta.</p>
            <div style="text-align: right; margin-top: 15px;">
                <a href="yadnya.php" class="btn" style="background-color: var(--color-primary); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="nilai-card-highlight">
            <h3>Tirtayatra (Perjalanan Suci)</h3>
            <p>Aktivitas spiritual berupa perjalanan menuju tempat-tempat suci (Pura) untuk memohon tirtha (air suci) dan penyucian diri.</p>
            <div style="text-align: right; margin-top: 15px;">
                <a href="tirtayatra.php" class="btn" style="background-color: var(--color-primary); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    
    <hr class="separator"> 
</main>

<?php
require_once 'footer.php'; 
?>