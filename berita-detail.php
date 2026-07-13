<?php
/**
 * Halaman Detail Berita - Native CSS (style.css)
 * Menampilkan detail isi berita berdasarkan ID
 */

$page_title = 'Detail Berita - Sistem Informasi Profil Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ? AND status = 'publish'");
    $stmt->execute([$id]);
    $berita = $stmt->fetch();
} else {
    $berita = false;
}

// Ambil data settings untuk nama koperasi
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator">/</span>
        <a href="berita.php">Berita</a>
        <span class="separator">/</span>
        <span class="current line-clamp-1">
            <?php echo $berita ? htmlspecialchars($berita['judul']) : 'Detail Berita'; ?>
        </span>
    </div>
</div>

<?php if ($berita): ?>
    <!-- ============================================================
         HEADER BERITA
         ============================================================ -->
    <section class="page-banner align-left">
        <div class="container">
            <div class="max-w-wide">
                <div class="meta-row">
                    <span class="meta-badge"><i class="fas fa-tag"></i><?php echo htmlspecialchars(ucfirst($berita['kategori'])); ?></span>
                    <span><i class="far fa-calendar-alt"></i><?php echo date('d F Y', strtotime($berita['tanggal'])); ?></span>
                    <span><i class="far fa-clock"></i><?php
                        $time_diff = time() - strtotime($berita['tanggal']);
                        $days = floor($time_diff / (60 * 60 * 24));
                        if ($days == 0) echo 'Hari ini';
                        elseif ($days == 1) echo 'Kemarin';
                        elseif ($days < 7) echo $days . ' hari yang lalu';
                        elseif ($days < 30) echo floor($days / 7) . ' minggu yang lalu';
                        else echo date('d F Y', strtotime($berita['tanggal']));
                    ?></span>
                </div>

                <h1><?php echo htmlspecialchars($berita['judul']); ?></h1>

                <div class="author-row">
                    <div class="author-avatar"><?php echo strtoupper(substr($nama_koperasi, 0, 1)); ?></div>
                    <div>
                        <p class="author-label">Dipublikasikan oleh</p>
                        <p class="author-name"><?php echo htmlspecialchars($nama_koperasi); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         KONTEN BERITA
         ============================================================ -->
    <section class="why-join">
        <div class="container">
            <div class="max-w-wide">
                <!-- Gambar Utama -->
                <?php
                $gambar = $berita['gambar'] ?? 'default.jpg';
                $path_gambar = '';
                if (file_exists('uploads/berita/' . $gambar)) {
                    $path_gambar = 'uploads/berita/' . $gambar;
                } elseif (file_exists('assets/img/' . $gambar)) {
                    $path_gambar = 'assets/img/' . $gambar;
                } else {
                    $path_gambar = 'assets/img/default.jpg';
                }
                ?>
                <div class="berita-detail-image" style="background-image:url('<?php echo $path_gambar; ?>');"></div>

                <!-- Share & Info Bar -->
                <div class="share-bar">
                    <div class="byline">
                        <div class="byline-avatar"><?php echo strtoupper(substr($nama_koperasi, 0, 1)); ?></div>
                        <div>
                            <p class="byline-label">Dipublikasikan oleh</p>
                            <p class="byline-name"><?php echo htmlspecialchars($nama_koperasi); ?></p>
                        </div>
                    </div>

                    <div class="share-buttons">
                        <span>Bagikan:</span>
                        <button onclick="shareOnFacebook()" class="fb" aria-label="Bagikan ke Facebook"><i class="fab fa-facebook-f"></i></button>
                        <button onclick="shareOnTwitter()" class="tw" aria-label="Bagikan ke X"><i class="fab fa-x-twitter"></i></button>
                        <button onclick="shareOnWhatsApp()" class="wa" aria-label="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i></button>
                        <button onclick="copyLink(this)" class="copy" aria-label="Salin tautan"><i class="fas fa-link"></i></button>
                    </div>
                </div>

                <!-- Isi Berita -->
                <div class="berita-detail-content">
                    <?php echo nl2br(htmlspecialchars_decode($berita['isi'])); ?>
                </div>

                <!-- Tags -->
                <div class="tag-list">
                    <span class="tag-label">Kategori:</span>
                    <span class="tag-pill"><?php echo htmlspecialchars(ucfirst($berita['kategori'])); ?></span>
                    <span class="tag-pill neutral"><?php echo htmlspecialchars($nama_koperasi); ?></span>
                    <span class="tag-pill neutral"><?php echo date('Y'); ?></span>
                </div>

                <!-- Navigasi Bawah -->
                <div class="btn-row-split">
                    <a href="berita.php" class="btn btn-neutral">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Berita
                    </a>
                    <div class="hero-buttons">
                        <a href="index.php" class="btn btn-neutral">
                            <i class="fas fa-home"></i>
                            Beranda
                        </a>
                        <a href="kontak.php" class="btn btn-primary">
                            <i class="fas fa-envelope"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                <!-- ============================================================
                     BERITA LAINNYA
                     ============================================================ -->
                <?php
                $stmt_other = $pdo->prepare("SELECT * FROM berita WHERE status = 'publish' AND id != ? ORDER BY tanggal DESC LIMIT 3");
                $stmt_other->execute([$id]);
                $berita_lainnya = $stmt_other->fetchAll();
                ?>

                <?php if (count($berita_lainnya) > 0): ?>
                <div class="mt-40 divider-top">
                    <div class="section-heading-inline">
                        <span class="bar"></span>
                        <h3>Berita Lainnya</h3>
                        <span class="subtitle">| Rekomendasi untuk Anda</span>
                    </div>

                    <div class="news-grid">
                        <?php foreach ($berita_lainnya as $other): ?>
                            <?php
                            $gambar_other = $other['gambar'] ?? 'default.jpg';
                            $path_gambar_other = '';
                            if (file_exists('uploads/berita/' . $gambar_other)) {
                                $path_gambar_other = 'uploads/berita/' . $gambar_other;
                            } elseif (file_exists('assets/img/' . $gambar_other)) {
                                $path_gambar_other = 'assets/img/' . $gambar_other;
                            } else {
                                $path_gambar_other = 'assets/img/default.jpg';
                            }
                            ?>
                            <a href="berita-detail.php?id=<?php echo $other['id']; ?>" class="news-card">
                                <div class="news-image" style="background-image:url('<?php echo $path_gambar_other; ?>');">
                                    <div class="overlay"></div>
                                    <?php if ($other['kategori'] == 'pengumuman'): ?>
                                        <span class="news-badge pengumuman"><i class="fas fa-bullhorn"></i>Pengumuman</span>
                                    <?php endif; ?>
                                </div>
                                <div class="news-body">
                                    <span class="date"><i class="far fa-calendar-alt"></i><?php echo date('d M Y', strtotime($other['tanggal'])); ?></span>
                                    <h3 class="line-clamp-2"><?php echo htmlspecialchars($other['judul']); ?></h3>
                                    <p class="line-clamp-2"><?php echo htmlspecialchars(substr(strip_tags($other['isi']), 0, 100)); ?>...</p>
                                    <span class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================================
         SHARE SCRIPTS
         ============================================================ -->
    <script>
    function shareOnFacebook() {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400');
    }

    function shareOnTwitter() {
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent('<?php echo htmlspecialchars($berita['judul']); ?>') + '&url=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400');
    }

    function shareOnWhatsApp() {
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent('<?php echo htmlspecialchars($berita['judul']); ?> - ' + window.location.href), '_blank', 'width=600,height=400');
    }

    function copyLink(btn) {
        navigator.clipboard.writeText(window.location.href).then(function() {
            var original = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.add('copied');
            setTimeout(function() {
                btn.innerHTML = original;
                btn.classList.remove('copied');
            }, 2000);
        }).catch(function() {
            alert('Gagal menyalin link. Silakan copy manual.');
        });
    }
    </script>

<?php else: ?>
    <!-- ============================================================
         BERITA TIDAK DITEMUKAN
         ============================================================ -->
    <section class="why-join">
        <div class="container">
            <div class="not-found">
                <div class="icon-circle"><i class="fas fa-exclamation-triangle"></i></div>
                <h2>Berita Tidak Ditemukan</h2>
                <p>Maaf, berita yang Anda cari tidak tersedia atau telah dihapus.</p>
                <a href="berita.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Berita
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
