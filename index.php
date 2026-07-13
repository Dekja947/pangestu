<?php
/**
 * Halaman Utama - Native CSS (style.css)
 */
$page_title = 'Beranda - Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// Ambil data settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';
$tagline = $settings['tagline'] ?? '"Bersama Tumbuh, Bersama Sejahtera"';
$tahun_berdiri = $settings['tahun_berdiri'] ?? '2009';
$stat_anggota = $settings['stat_anggota'] ?? '500+';
$stat_tahun = $settings['stat_tahun'] ?? '15+';
$stat_aset = $settings['stat_aset'] ?? 'Rp 2 M+';
$stat_usaha = $settings['stat_usaha'] ?? '3';

// Ambil data
$stmt = $pdo->prepare("SELECT * FROM berita WHERE status = 'publish' ORDER BY tanggal DESC LIMIT 3");
$stmt->execute();
$berita_terbaru = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM galeri ORDER BY tanggal DESC LIMIT 6");
$stmt->execute();
$galeri = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM pengurus ORDER BY urutan ASC");
$stmt->execute();
$pengurus = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="hero-grid"></div>

    <!-- Elemen khas: cincin saling bertaut, melambangkan gotong royong / kerja sama koperasi -->
    <div class="hero-signature">
        <svg viewBox="0 0 580 580">
            <circle cx="270" cy="220" r="150" fill="none" stroke="rgba(255,255,255,0.10)" stroke-width="1.5"/>
            <circle cx="380" cy="330" r="180" fill="none" stroke="rgba(245,158,11,0.20)" stroke-width="1.5"/>
            <circle cx="200" cy="360" r="115" fill="none" stroke="rgba(52,211,153,0.22)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="badge">
                <span class="dot"></span>
                Koperasi Terpercaya Sejak <?php echo $tahun_berdiri; ?>
            </div>

            <h1>
                <?php echo htmlspecialchars($nama_koperasi); ?>
                <span class="highlight">Makmur Mandiri</span>
            </h1>

            <p class="tagline">
                <?php echo htmlspecialchars($tagline); ?> <i class="fas fa-circle" style="font-size:6px;vertical-align:middle;"></i> Koperasi simpan pinjam dan serba usaha yang memberdayakan masyarakat
            </p>

            <div class="hero-buttons">
                <a href="kontak.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Bergabung Sekarang
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="profil.php" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Pelajari Lebih Lanjut
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <span class="stat-number"><?php echo $stat_anggota; ?></span>
                    <span class="stat-label">Anggota Aktif</span>
                </div>
                <div>
                    <span class="stat-number"><?php echo $stat_tahun; ?></span>
                    <span class="stat-label">Tahun Berdiri</span>
                </div>
                <div>
                    <span class="stat-number"><?php echo $stat_aset; ?></span>
                    <span class="stat-label">Total Aset</span>
                </div>
                <div>
                    <span class="stat-number"><?php echo $stat_usaha; ?></span>
                    <span class="stat-label">Unit Usaha</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     PENGURUS SECTION
     ============================================================ -->
<?php if (count($pengurus) > 0): ?>
<section class="pengurus-home">
    <div class="container">
        <h2 class="section-title reveal-group">
            Pengurus <span class="highlight">Koperasi</span>
            <span class="decoration"></span>
        </h2>
        <p class="section-subtitle">Pengurus yang profesional dan berdedikasi</p>

        <div class="pengurus-grid reveal-group">
            <?php foreach ($pengurus as $p): ?>
                <?php
                $foto_path = '';
                if (!empty($p['foto'])) {
                    if (file_exists('uploads/pengurus/' . $p['foto'])) {
                        $foto_path = 'uploads/pengurus/' . $p['foto'];
                    } elseif (file_exists('assets/img/' . $p['foto'])) {
                        $foto_path = 'assets/img/' . $p['foto'];
                    }
                }
                ?>
                <div class="pengurus-card">
                    <div class="photo-wrapper">
                        <div class="avatar">
                            <?php if (!empty($foto_path)): ?>
                                <img src="<?php echo $foto_path; ?>" alt="<?php echo htmlspecialchars($p['nama']); ?>">
                            <?php else: ?>
                                <div class="avatar-placeholder"><i class="fas fa-user"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="badge-jabatan"><?php echo htmlspecialchars($p['jabatan']); ?></div>
                    </div>
                    <div class="pengurus-info">
                        <h4><?php echo htmlspecialchars($p['nama']); ?></h4>
                        <div class="divider"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     STATISTICS SECTION
     ============================================================ -->
<section class="statistics">
    <div class="container">
        <h2 class="section-title reveal-group">
            Koperasi dalam <span class="highlight">Angka</span>
            <span class="decoration"></span>
        </h2>

        <div class="stats-grid reveal-group">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <span class="stat-number"><?php echo $stat_anggota; ?></span>
                <div class="stat-label">Anggota Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon icon-navy"><i class="fas fa-calendar-alt"></i></div>
                <span class="stat-number"><?php echo $stat_tahun; ?></span>
                <div class="stat-label">Tahun Berdiri</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon icon-gold"><i class="fas fa-chart-line"></i></div>
                <span class="stat-number"><?php echo $stat_aset; ?></span>
                <div class="stat-label">Total Aset</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon icon-sapphire"><i class="fas fa-store"></i></div>
                <span class="stat-number"><?php echo $stat_usaha; ?></span>
                <div class="stat-label">Unit Usaha</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SERVICES SECTION
     ============================================================ -->
<section class="services">
    <div class="container">
        <h2 class="section-title reveal-group">
            Layanan <span class="highlight">Unggulan</span>
            <span class="decoration"></span>
        </h2>
        <p class="section-subtitle">Berbagai layanan terbaik untuk anggota</p>

        <div class="services-grid reveal-group">
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-wallet"></i></div>
                <h3>Simpan Pinjam</h3>
                <p>Tabungan dan pinjaman dengan bunga ringan</p>
            </div>
            <div class="service-card">
                <div class="service-icon icon-sapphire"><i class="fas fa-shopping-basket"></i></div>
                <h3>Koperasi Konsumsi</h3>
                <p>Kebutuhan sehari-hari harga terjangkau</p>
            </div>
            <div class="service-card">
                <div class="service-icon icon-navy"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Pendampingan Usaha</h3>
                <p>Pelatihan dan pembinaan UMKM</p>
            </div>
            <div class="service-card">
                <div class="service-icon icon-gold"><i class="fas fa-shield-alt"></i></div>
                <h3>Asuransi Anggota</h3>
                <p>Perlindungan bagi anggota aktif</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     WHY JOIN SECTION
     ============================================================ -->
<section class="why-join">
    <div class="container">
        <div class="why-grid">
            <div class="why-content">
                <h2 class="section-title">
                    Mengapa <span class="highlight">Bergabung?</span>
                    <span class="decoration"></span>
                </h2>
                <p><?php echo htmlspecialchars($nama_koperasi); ?> memberikan manfaat dan keuntungan bagi setiap anggotanya.</p>

                <?php
                $features = [
                    ['icon' => 'check-circle', 'title' => 'Keuangan Sehat', 'desc' => 'Sistem simpan pinjam yang transparan dan terpercaya'],
                    ['icon' => 'check-circle', 'title' => 'Pemberdayaan Anggota', 'desc' => 'Pendampingan usaha dan pelatihan bisnis'],
                    ['icon' => 'check-circle', 'title' => 'Kebutuhan Terpenuhi', 'desc' => 'Akses kebutuhan pokok dengan harga khusus'],
                    ['icon' => 'check-circle', 'title' => 'Perlindungan Maksimal', 'desc' => 'Asuransi untuk rasa aman Anda dan keluarga'],
                ];
                ?>
                <ul class="why-features reveal-group">
                    <?php foreach ($features as $feature): ?>
                        <li>
                            <div class="icon-wrapper"><i class="fas fa-<?php echo $feature['icon']; ?>"></i></div>
                            <div>
                                <strong><?php echo $feature['title']; ?></strong>
                                <span><?php echo $feature['desc']; ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="why-image">
                <?php if (file_exists('assets/img/hero-bg.jpg')): ?>
                    <img src="assets/img/hero-bg.jpg" alt="<?php echo htmlspecialchars($nama_koperasi); ?>">
                <?php else: ?>
                    <div class="why-image-placeholder"><i class="fas fa-building"></i></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     NEWS SECTION
     ============================================================ -->
<section class="news">
    <div class="container">
        <h2 class="section-title reveal-group">
            Berita & <span class="highlight">Pengumuman</span>
            <span class="decoration"></span>
        </h2>

        <div class="news-grid reveal-group">
            <?php if (count($berita_terbaru) > 0): ?>
                <?php foreach ($berita_terbaru as $berita): ?>
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
                    <div class="news-card">
                        <div class="news-image" style="background-image:url('<?php echo $path_gambar; ?>');">
                            <div class="overlay"></div>
                            <span class="news-badge <?php echo $berita['kategori']; ?>"><?php echo htmlspecialchars($berita['kategori']); ?></span>
                        </div>
                        <div class="news-body">
                            <span class="date"><i class="far fa-calendar-alt"></i><?php echo date('d F Y', strtotime($berita['tanggal'])); ?></span>
                            <h3><a href="berita-detail.php?id=<?php echo $berita['id']; ?>"><?php echo htmlspecialchars($berita['judul']); ?></a></h3>
                            <p class="line-clamp-2"><?php echo htmlspecialchars(substr(strip_tags($berita['isi']), 0, 120)); ?>...</p>
                            <a href="berita-detail.php?id=<?php echo $berita['id']; ?>" class="read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p>Belum ada berita terbaru</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-40">
            <a href="berita.php" class="btn btn-primary">
                <i class="fas fa-newspaper"></i>
                Lihat Semua Berita
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     GALERI SECTION
     ============================================================ -->
<?php if (count($galeri) > 0): ?>
<section class="gallery">
    <div class="container">
        <h2 class="section-title reveal-group">
            Galeri <span class="highlight">Kegiatan</span>
            <span class="decoration"></span>
        </h2>

        <div class="gallery-grid reveal-group">
            <?php foreach ($galeri as $g): ?>
                <?php
                $path_gambar = '';
                if (file_exists('uploads/galeri/' . $g['gambar'])) {
                    $path_gambar = 'uploads/galeri/' . $g['gambar'];
                } elseif (file_exists('assets/img/' . $g['gambar'])) {
                    $path_gambar = 'assets/img/' . $g['gambar'];
                } else {
                    $path_gambar = 'assets/img/default.jpg';
                }
                ?>
                <div class="gallery-item">
                    <img src="<?php echo $path_gambar; ?>" alt="<?php echo htmlspecialchars($g['judul']); ?>">
                    <div class="caption">
                        <h4><?php echo htmlspecialchars($g['judul']); ?></h4>
                        <small><i class="far fa-calendar-alt"></i><?php echo date('d F Y', strtotime($g['tanggal'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     CALL TO ACTION
     ============================================================ -->
<section class="cta-section">
    <div class="container">
        <h2>Siap Bergabung dengan Kami?</h2>
        <p>Jadilah bagian dari <?php echo htmlspecialchars($nama_koperasi); ?> dan rasakan manfaatnya</p>
        <a href="kontak.php" class="btn">
            <i class="fas fa-user-plus"></i>
            Daftar Sekarang
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- Tombol #scroll-top: elemen tombolnya kemungkinan sudah ada di includes/footer.php Anda
     (stylingnya sudah tersedia di style.css bagian "15. SCROLL TO TOP") -->

<?php include 'includes/footer.php'; ?>
