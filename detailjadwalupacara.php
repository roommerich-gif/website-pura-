<?php

session_start();

require_once 'koneksi.php'; 

$id_kegiatan = $_GET['id'] ?? $_GET['id_kegiatan'] ?? null;

$kegiatan = null;
$error_message = "";


function format_tanggal_indonesia($tanggal) {
   
    if (!$tanggal || strtotime($tanggal) === false) {
        return "Tanggal tidak tersedia";
    }

    $bulan = [
        "01" => "Januari", "02" => "Februari", "03" => "Maret",
        "04" => "April", "05" => "Mei", "06" => "Juni",
        "07" => "Juli", "08" => "Agustus", "09" => "September",
        "10" => "Oktober", "11" => "November", "12" => "Desember"
    ];
    
    $tgl = date("d", strtotime($tanggal));
    $bln_key = date("m", strtotime($tanggal));
    $bln = $bulan[$bln_key] ?? $bln_key;
    $thn = date("Y", strtotime($tanggal));
    
    return "$tgl $bln $thn";
}


if ($id_kegiatan && is_numeric($id_kegiatan)) {
    
    $stmt = $conn->prepare("
        SELECT id_kegiatan, judul, tanggal, waktu, lokasi, deskripsi_lengkap 
        FROM jadwal_upacara
        WHERE id_kegiatan = ?
    ");

    if ($stmt === false) {
        $error_message = "Gagal menyiapkan statement database: " . $conn->error;
    } else {
        $stmt->bind_param("i", $id_kegiatan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $kegiatan = $result->fetch_assoc();
        } else {
            $error_message = "Data kegiatan tidak ditemukan.";
        }

        $stmt->close();
    }
} else {
    $error_message = "ID kegiatan tidak valid.";
}

$is_kegiatan_detail_page = true;


$pageTitle = $kegiatan ? $kegiatan['judul'] : "Detail Kegiatan";
require_once "header.php"; 
?>

<style>
.detail-wrapper {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    max-width: 750px;
    margin: 0 auto; 
    text-align: center; 
}

.kegiatan-title {
    font-size: 1.9rem !important;
    text-align: center; 
    margin: 0 auto 20px auto; 
    max-width: 750px;
    color: var(--color-secondary) !important;
    text-transform: capitalize;
    font-weight: 700;
}

.detail-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 25px;
    border-bottom: 1px dashed #ccc;
    padding-bottom: 15px;
    justify-content: center; 
}

.detail-box {
    min-width: 150px;
    text-align: center;
}

.detail-box h4 {
    color: #555;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.detail-box p {
    font-size: 1.1rem;
    color: var(--color-secondary);
    font-weight: 600;
    margin: 0;
}

.description {
    text-align: center;
    margin-top: 20px;
}

.description h3 {
    font-size: 1.4rem;
    color: var(--color-secondary);
    margin-bottom: 15px;
    font-weight: 700;
}

.description p {
    font-size: 1rem !important;
    color: #444;
    line-height: 1.8;
    text-align: justify;
    text-justify: inter-word;
    text-indent: 0;
    padding: 0;
    margin: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}

.center-container {
    padding: 50px 0; 
    max-width: 900px;
    margin: 0 auto; 
    display: flex;
    flex-direction: column;
    align-items: center; 
}

@media(max-width: 768px){
    .detail-meta { 
        flex-direction: column; 
        align-items: center; 
    }
    .detail-box {
        min-width: 100%; 
    }
    .description p {
        font-size: 0.95rem !important;
        text-align: left;
    }
}
</style>

<section class="section-title-header" style="padding: 10px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
    <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
        Detail Jadwal Kegiatan
    </h1>
    <p style="font-size: 1.1em; color: #777; margin-top: 0; line-height: 1.5;">
        Informasi lebih lengkap mengenai kegiatan keagamaan.
    </p>
</section>

<section class="container center-container">

<?php if ($kegiatan): ?>

    <h2 class="kegiatan-title">
        <?= htmlspecialchars($kegiatan['judul']) ?>
    </h2>

    <div class="detail-wrapper">

        <div class="detail-meta">

            <div class="detail-box">
                <h4><i class="fas fa-calendar-alt"></i> Tanggal</h4>
                <p><?= format_tanggal_indonesia($kegiatan['tanggal']) ?></p>
            </div>

            <div class="detail-box">
                <h4><i class="fas fa-clock"></i> Waktu</h4>
                <p><?= date("H:i", strtotime($kegiatan['waktu'])) ?> WITA</p>
            </div>

            <div class="detail-box">
                <h4><i class="fas fa-map-marker-alt"></i> Lokasi</h4>
                <p><?= htmlspecialchars($kegiatan['lokasi']) ?></p>
            </div>

        </div>

        <div class="description">
            <h3>Penjelasan Lengkap</h3>
            <p><?= nl2br(htmlspecialchars($kegiatan['deskripsi_lengkap'])) ?></p>
        </div>

    </div>

<?php else: ?>
    <div style="background:#ffe2e2; padding:20px; border-radius:10px; text-align:center;">
        <h3 style="color:#b30000;">Data Tidak Ditemukan</h3>
        <p><?= htmlspecialchars($error_message) ?></p>
    </div>
<?php endif; ?>

    <div style="text-align:center; margin-top:30px;">
        <a href="index.php#kegiatan" class="btn" 
            style="padding:10px 20px; background:var(--color-secondary); color:white; border-radius:20px; font-weight:600;">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal
        </a>
    </div>

</section>

<?php 

require_once "footer.php"; 
?>