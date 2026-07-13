<?php
/**
 * Halaman Profil - Native CSS (style.css)
 * Menampilkan sejarah, visi misi, struktur organisasi, dan legalitas
 * Semua data dari database, foto pengurus dari folder uploads/
 */

$page_title = 'Profil - Sistem Informasi Profil Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// ============================================================
// 1. AMBIL DATA SETTINGS (Profil Koperasi)
// ============================================================
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Set variabel dari database
$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';
$tagline = $settings['tagline'] ?? '"Bersama Tumbuh, Bersama Sejahtera"';
$alamat = $settings['alamat'] ?? 'Jl. Raya Pringsewu No. 123, Kabupaten Pringsewu, Lampung';
$telepon = $settings['telepon'] ?? '0729-123456';
$email = $settings['email'] ?? 'koperasi.smm@email.com';
$tahun_berdiri = $settings['tahun_berdiri'] ?? '2009';
$badan_hukum = $settings['badan_hukum'] ?? '123/XX/2009';
$sejarah = $settings['sejarah'] ?? '';
$visi = $settings['visi'] ?? '';
$misi = $settings['misi'] ?? '';

// ============================================================
// 2. AMBIL DATA PENGURUS
// ============================================================
$stmt = $pdo->query("SELECT * FROM pengurus ORDER BY urutan ASC");
$pengurus = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator">/</span>
        <span class="current"><i class="fas fa-address-card"></i> Profil</span>
    </div>
</div>

<!-- ============================================================
     HEADER SECTION
     ============================================================ -->
<section class="services">
    <div class="container">
        <div class="text-center max-w-narrow reveal-group">
            <h1 class="section-title">
                Profil <span class="highlight">Koperasi</span>
                <span class="decoration"></span>
            </h1>
            <p class="section-subtitle">
                Mengenal lebih dekat <?php echo htmlspecialchars($nama_koperasi); ?>, koperasi yang berkomitmen untuk kesejahteraan anggota
            </p>
        </div>
    </div>
</section>

<!-- ============================================================
     SEJARAH
     ============================================================ -->
<section class="why-join">
    <div class="container">
        <div class="profile-card">
            <h3><i class="fas fa-history"></i>Sejarah Berdirinya</h3>

            <?php if (!empty($sejarah)): ?>
                <p><?php echo nl2br(htmlspecialchars_decode($sejarah)); ?></p>
            <?php else: ?>
                <p>
                    <?php echo htmlspecialchars($nama_koperasi); ?> didirikan pada tahun <?php echo $tahun_berdiri; ?>
                    oleh sekelompok masyarakat Kabupaten Pringsewu yang memiliki semangat gotong royong dan
                    keinginan untuk meningkatkan kesejahteraan ekonomi bersama. Berawal dari pengajuan pinjaman
                    kecil dan usaha simpan pinjam sederhana, koperasi ini terus berkembang menjadi salah satu
                    koperasi terkemuka di Kabupaten Pringsewu.
                </p>
                <p>
                    Dengan semangat <?php echo htmlspecialchars($tagline); ?>, <?php echo htmlspecialchars($nama_koperasi); ?>
                    berkomitmen untuk memberikan layanan terbaik bagi anggota dan terus berkontribusi dalam
                    pembangunan ekonomi masyarakat Kabupaten Pringsewu dan sekitarnya.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     VISI & MISI
     ============================================================ -->
<section class="services">
    <div class="container">
        <div class="visi-misi-grid">
            <!-- Visi -->
            <div class="visi-card">
                <h3><i class="fas fa-eye"></i>Visi</h3>
                <?php if (!empty($visi)): ?>
                    <p><?php echo nl2br(htmlspecialchars_decode($visi)); ?></p>
                <?php else: ?>
                    <p>"Menjadi koperasi terpercaya yang mandiri, profesional, dan memberdayakan ekonomi masyarakat Kabupaten Pringsewu melalui layanan keuangan yang berkualitas."</p>
                <?php endif; ?>
            </div>

            <!-- Misi -->
            <div class="misi-card">
                <h3><i class="fas fa-bullseye"></i>Misi</h3>
                <?php if (!empty($misi)): ?>
                    <ul>
                        <?php
                        $misi_items = explode("\n", $misi);
                        foreach ($misi_items as $item):
                            $item = trim($item);
                            if (!empty($item)):
                        ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li>Menyediakan layanan simpan pinjam yang mudah, cepat, dan transparan bagi anggota</li>
                        <li>Mengembangkan usaha koperasi yang berorientasi pada kesejahteraan anggota</li>
                        <li>Memberdayakan UMKM anggota melalui pendampingan dan pelatihan usaha</li>
                        <li>Menjaga profesionalisme dan integritas dalam setiap pelayanan</li>
                        <li>Membangun kemitraan yang saling menguntungkan dengan berbagai pihak</li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     STRUKTUR PENGURUS
     ============================================================ -->
<section class="why-join">
    <div class="container">
        <div class="section-heading-inline reveal-group">
            <span class="bar"></span>
            <div>
                <h3>Struktur <span class="text-gradient">Pengurus</span></h3>
                <span class="subtitle">Pengurus yang berdedikasi dalam mengelola koperasi</span>
            </div>
        </div>

        <?php if (count($pengurus) > 0): ?>
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
                    if (empty($foto_path)) {
                        $foto_path = 'assets/img/default-avatar.jpg';
                    }
                    ?>
                    <div class="pengurus-card">
                        <div class="pengurus-foto" style="background-image:url('<?php echo $foto_path; ?>');"></div>
                        <div class="pengurus-info">
                            <h4><?php echo htmlspecialchars($p['nama']); ?></h4>
                            <p><?php echo htmlspecialchars($p['jabatan']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state bordered">
                <i class="fas fa-users"></i>
                <p>Data pengurus belum tersedia. Silakan tambahkan melalui panel admin.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================================
     LEGALITAS
     ============================================================ -->
<section class="services">
    <div class="container">
        <div class="profile-card">
            <h3><i class="fas fa-gavel"></i>Legalitas Koperasi</h3>

            <div class="legal-grid">
                <div class="legal-item">
                    <p class="legal-label">Badan Hukum</p>
                    <p class="legal-value">Nomor: <?php echo htmlspecialchars($badan_hukum); ?></p>
                    <p class="legal-sub">Tanggal: 15 Januari <?php echo $tahun_berdiri; ?></p>
                </div>
                <div class="legal-item navy">
                    <p class="legal-label">Akta Notaris</p>
                    <p class="legal-value">Nomor: 45/<?php echo $tahun_berdiri; ?></p>
                    <p class="legal-sub">Notaris: Hj. Sri Mulyani, S.H.</p>
                </div>
                <div class="legal-item gold">
                    <p class="legal-label">NPWP</p>
                    <p class="legal-value">01.234.567.8-912.000</p>
                </div>
                <div class="legal-item">
                    <p class="legal-label">Izin Usaha</p>
                    <p class="legal-value">Nomor: 678/IX/<?php echo $tahun_berdiri; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     INFO KONTAK
     ============================================================ -->
<section class="why-join">
    <div class="container">
        <div class="profile-card tinted">
            <h3><i class="fas fa-address-card"></i>Informasi Kontak</h3>

            <div class="info-box-grid">
                <div class="info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <p class="info-label">Alamat</p>
                        <p class="info-value"><?php echo htmlspecialchars($alamat); ?></p>
                    </div>
                </div>
                <div class="info-box">
                    <i class="fas fa-phone"></i>
                    <div>
                        <p class="info-label">Telepon</p>
                        <p class="info-value"><?php echo htmlspecialchars($telepon); ?></p>
                    </div>
                </div>
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <p class="info-label">Email</p>
                        <p class="info-value break-word"><?php echo htmlspecialchars($email); ?></p>
                    </div>
                </div>
                <div class="info-box">
                    <i class="fas fa-globe"></i>
                    <div>
                        <p class="info-label">Website</p>
                        <p class="info-value"><?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     TOMBOL NAVIGASI
     ============================================================ -->
<section class="services">
    <div class="container">
        <div class="hero-buttons justify-center">
            <a href="index.php" class="btn btn-neutral">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
            <a href="layanan.php" class="btn btn-primary">
                Lihat Layanan Kami
                <i class="fas fa-arrow-right"></i>
            </a>
            <a href="kontak.php" class="btn btn-outline">
                <i class="fas fa-envelope"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
