<?php
session_start();
require_once "koneksi.php";

$pageTitle = "Galeri Foto Pura";
require_once "header.php";
?>

<style>
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 5%;
}
.gallery-item {
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    cursor: pointer;
    background: #000;
}
.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* === FOTO === */
.gallery-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
    transition: opacity 0.3s;
}
.gallery-item:hover img { opacity: 0.9; }

/* === VIDEO THUMBNAIL === */
.gallery-item .video-thumb {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
    pointer-events: none; /* klik tetap ke gallery-item */
}
.video-play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.85);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
    pointer-events: none;
}
.video-play-overlay svg { width: 22px; height: 22px; fill: #333; margin-left: 3px; }
.gallery-item:hover .video-play-overlay { background: rgba(255,153,0,0.92); }
.gallery-item:hover .video-play-overlay svg { fill: white; }

/* === CAPTION === */
.photo-caption {
    position: absolute;
    bottom: 0; left: 0;
    width: 100%;
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 10px 15px;
    font-size: 0.9em;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}
.gallery-item:hover .photo-caption { transform: translateY(0); }

/* === RESPONSIVE === */
@media (max-width: 992px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) {
    .gallery-grid { grid-template-columns: 1fr; }
    .gallery-item img,
    .gallery-item .video-thumb { height: 200px; }
}

/* === LIGHTBOX === */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.92);
    overflow: auto;
    padding-top: 50px;
}
.modal-inner {
    margin: auto;
    width: 90%;
    max-width: 800px;
    text-align: center;
}
.modal-inner img {
    max-width: 100%;
    max-height: 75vh;
    border-radius: 8px;
    display: block;
    margin: 0 auto;
}
.modal-inner video {
    max-width: 100%;
    max-height: 75vh;
    border-radius: 8px;
    display: block;
    margin: 0 auto;
    background: #000;
}
#lightbox-caption {
    color: #ccc;
    padding: 12px 0 0;
    font-size: 0.95rem;
}
.close-btn {
    position: fixed;
    top: 15px; right: 30px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
    z-index: 1001;
}
.close-btn:hover { color: #FF9900; }
</style>

<main>

<section class="section-title-header" style="padding: 15px 0; background-color: var(--color-light-bg, #f4f4f9); text-align: center;">
    <h1 style="font-size: 2.5em; margin: 0 0 10px 0; color: var(--color-secondary, #333); letter-spacing: 1px;">
        Galeri Foto Pura
    </h1>
    <p style="font-size: 1.1em; color: #777; margin-top: 0; line-height: 1.5;">
        Dokumentasi kegiatan, upacara, dan keindahan Pura Mandira Taman Sari.
    </p>
</section>

<section class="gallery-section" style="padding: 10px 0;">
    <div class="gallery-grid">
        <?php
        $sql = "SELECT id_foto, judul_foto, deskripsi, path_file, tipe_media
                FROM galeri
                WHERE status = 'aktif'
                ORDER BY id_foto DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $src     = htmlspecialchars($row['path_file']);
                $judul   = htmlspecialchars($row['judul_foto']);
                $caption = $judul;
                if (!empty($row['deskripsi'])) $caption .= ' (' . htmlspecialchars($row['deskripsi']) . ')';

                // Deteksi video dari kolom tipe_media atau ekstensi
                $ext     = strtolower(pathinfo($row['path_file'], PATHINFO_EXTENSION));
                $isVideo = ($row['tipe_media'] === 'video') || in_array($ext, ['mp4','webm','ogg']);
        ?>
        <div class="gallery-item"
             onclick="openLightbox('<?= $src ?>', '<?= $caption ?>', <?= $isVideo ? 'true' : 'false' ?>)">

            <?php if ($isVideo): ?>
                <video class="video-thumb" src="<?= $src ?>" preload="metadata" muted></video>
                <div class="video-play-overlay">
                    <svg viewBox="0 0 24 24"><polygon points="5,3 19,12 5,21"/></svg>
                </div>
            <?php else: ?>
                <img src="<?= $src ?>" alt="<?= $judul ?>"
                     onerror="this.closest('.gallery-item').style.display='none'">
            <?php endif; ?>

            <div class="photo-caption"><?= $judul ?></div>
        </div>
        <?php
            endwhile;
        else:
        ?>
            <div style="grid-column:1/-1; text-align:center; padding:50px;">
                <p style="color:#888; font-style:italic;">Belum ada foto yang diunggah.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<hr class="separator">
</main>

<!-- LIGHTBOX -->
<div id="lightbox-modal" class="modal" onclick="closeLightbox(event)">
    <span class="close-btn" onclick="closeLightbox()">&times;</span>
    <div class="modal-inner" onclick="event.stopPropagation()">
        <img id="lightbox-image" src="" alt="" style="display:none;">
        <video id="lightbox-video" controls style="display:none;"></video>
        <div id="lightbox-caption"></div>
    </div>
</div>

<script>
const modal      = document.getElementById('lightbox-modal');
const lbImage    = document.getElementById('lightbox-image');
const lbVideo    = document.getElementById('lightbox-video');
const lbCaption  = document.getElementById('lightbox-caption');

function openLightbox(src, caption, isVideo) {
    modal.style.display = "block";
    lbCaption.innerHTML = caption;

    if (isVideo) {
        lbImage.style.display = "none";
        lbVideo.style.display = "block";
        lbVideo.src = src;
        lbVideo.play();
    } else {
        lbVideo.style.display = "none";
        lbVideo.pause();
        lbVideo.src = "";
        lbImage.style.display = "block";
        lbImage.src = src;
    }
}

function closeLightbox(e) {
    if (e && e.target !== modal) return;
    modal.style.display = "none";
    lbVideo.pause();
    lbVideo.src = "";
}

// Tombol X
document.querySelector('.close-btn').addEventListener('click', () => {
    modal.style.display = "none";
    lbVideo.pause();
    lbVideo.src = "";
});

document.addEventListener('keydown', e => {
    if (e.key === "Escape") {
        modal.style.display = "none";
        lbVideo.pause();
        lbVideo.src = "";
    }
});
</script>

<?php require_once "footer.php"; ?>