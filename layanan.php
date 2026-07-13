<?php
/**
 * Halaman Layanan - Native CSS (style.css)
 * Menampilkan layanan unggulan koperasi
 */
$page_title = 'Layanan - Sistem Informasi Profil Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// Ambil data settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';
$tagline = $settings['tagline'] ?? '"Bersama Tumbuh, Bersama Sejahtera"';

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator">/</span>
        <span class="current">Layanan</span>
    </div>
</div>

<!-- Header Section -->
<section class="page-banner">
    <div class="container">
        <h1>Layanan <span class="highlight">Koperasi</span></h1>
        <p>Berbagai layanan unggulan untuk kesejahteraan anggota <?php echo htmlspecialchars($nama_koperasi); ?></p>
    </div>
</section>

<!-- Layanan Content -->
<section class="why-join">
    <div class="container">

        <!-- ============================================================
             LAYANAN 1: SIMPAN PINJAM
             ============================================================ -->
        <div class="service-detail card" id="simpan-pinjam">
            <div class="service-icon-large"><i class="fas fa-wallet"></i></div>
            <span class="tag-pill">Layanan Utama #1</span>
            <h3>Simpan Pinjam</h3>
            <p>
                Layanan simpan pinjam merupakan layanan utama <?php echo htmlspecialchars($nama_koperasi); ?> yang memungkinkan anggota
                untuk menabung dan mengajukan pinjaman dengan bunga yang kompetitif. Sistem simpan pinjam kami dirancang
                untuk membantu anggota dalam memenuhi kebutuhan keuangan jangka pendek maupun jangka panjang.
            </p>
            <p class="detail-label"><i class="fas fa-star"></i>Keunggulan:</p>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i>Proses pengajuan pinjaman yang cepat dan mudah</li>
                <li><i class="fas fa-check-circle"></i>Bunga pinjaman yang ringan dan transparan</li>
                <li><i class="fas fa-check-circle"></i>Berbagai jenis tabungan sesuai kebutuhan</li>
                <li><i class="fas fa-check-circle"></i>Layanan yang ramah dan profesional</li>
            </ul>
        </div>

        <!-- ============================================================
             LAYANAN 2: KOPERASI KONSUMSI
             ============================================================ -->
        <div class="service-detail card" id="konsumsi">
            <div class="service-icon-large"><i class="fas fa-shopping-basket"></i></div>
            <span class="tag-pill">Kebutuhan Pokok #2</span>
            <h3>Koperasi Konsumsi</h3>
            <p>
                Koperasi Konsumsi menyediakan berbagai kebutuhan sehari-hari bagi anggota dengan harga yang terjangkau.
                Melalui unit usaha ini, anggota dapat memenuhi kebutuhan pokok dengan kualitas terbaik dan harga bersaing.
            </p>
            <p class="detail-label"><i class="fas fa-box"></i>Produk yang tersedia:</p>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i>Bahan pokok (beras, gula, minyak goreng, dll)</li>
                <li><i class="fas fa-check-circle"></i>Kebutuhan rumah tangga</li>
                <li><i class="fas fa-check-circle"></i>Produk-produk UMKM anggota</li>
            </ul>
        </div>

        <!-- ============================================================
             LAYANAN 3: PENDAMPINGAN USAHA
             ============================================================ -->
        <div class="service-detail card" id="pendampingan">
            <div class="service-icon-large"><i class="fas fa-chalkboard-teacher"></i></div>
            <span class="tag-pill">Pemberdayaan #3</span>
            <h3>Pendampingan Usaha</h3>
            <p>
                <?php echo htmlspecialchars($nama_koperasi); ?> berkomitmen untuk memberdayakan anggota melalui program pendampingan usaha.
                Program ini mencakup pelatihan, konsultasi bisnis, dan pembinaan bagi pelaku UMKM agar usahanya dapat
                berkembang dan berdaya saing.
            </p>
            <p class="detail-label"><i class="fas fa-graduation-cap"></i>Program yang tersedia:</p>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i>Pelatihan manajemen usaha dan keuangan</li>
                <li><i class="fas fa-check-circle"></i>Konsultasi pemasaran dan pengembangan produk</li>
                <li><i class="fas fa-check-circle"></i>Bimbingan teknis untuk UMKM</li>
                <li><i class="fas fa-check-circle"></i>Akses ke jaringan bisnis yang lebih luas</li>
            </ul>
        </div>

        <!-- ============================================================
             LAYANAN 4: ASURANSI ANGGOTA
             ============================================================ -->
        <div class="service-detail card" id="asuransi">
            <div class="service-icon-large"><i class="fas fa-shield-alt"></i></div>
            <span class="tag-pill">Perlindungan #4</span>
            <h3>Asuransi Anggota</h3>
            <p>
                Sebagai bentuk perlindungan bagi anggota aktif, <?php echo htmlspecialchars($nama_koperasi); ?> menyediakan program
                asuransi yang mencakup perlindungan jiwa dan kesehatan. Dengan menjadi anggota, Anda dan keluarga
                mendapatkan rasa aman dan perlindungan yang layak.
            </p>
            <p class="detail-label"><i class="fas fa-heart"></i>Manfaat asuransi:</p>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i>Perlindungan jiwa bagi anggota aktif</li>
                <li><i class="fas fa-check-circle"></i>Santunan kematian dan kecelakaan</li>
                <li><i class="fas fa-check-circle"></i>Premi asuransi yang terjangkau</li>
                <li><i class="fas fa-check-circle"></i>Proses klaim yang mudah dan cepat</li>
            </ul>
        </div>

        <!-- ============================================================
             SYARAT & KETENTUAN
             ============================================================ -->
        <div class="mt-40">
            <div class="text-center max-w-narrow mb-40 reveal-group">
                <h2 class="section-title">
                    Syarat & <span class="highlight">Ketentuan</span>
                    <span class="decoration"></span>
                </h2>
            </div>

            <div class="visi-misi-grid">
                <!-- Syarat -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="icon-box"><i class="fas fa-clipboard-list"></i></div>
                        <h4>Syarat Menjadi Anggota</h4>
                    </div>
                    <ul>
                        <li><i class="fas fa-check-circle"></i>Warga Negara Indonesia</li>
                        <li><i class="fas fa-check-circle"></i>Usia minimal 18 tahun</li>
                        <li><i class="fas fa-check-circle"></i>Memiliki KTP dan KK</li>
                        <li><i class="fas fa-check-circle"></i>Bersedia mematuhi AD/ART koperasi</li>
                        <li><i class="fas fa-check-circle"></i>Membayar simpanan pokok dan simpanan wajib</li>
                    </ul>
                </div>

                <!-- Keuntungan -->
                <div class="info-card gold">
                    <div class="info-card-header">
                        <div class="icon-box"><i class="fas fa-gem"></i></div>
                        <h4>Keuntungan Menjadi Anggota</h4>
                    </div>
                    <ul>
                        <li><i class="fas fa-check-circle"></i>Akses pinjaman dengan bunga ringan</li>
                        <li><i class="fas fa-check-circle"></i>Belanja kebutuhan di koperasi konsumsi</li>
                        <li><i class="fas fa-check-circle"></i>Mendapatkan pendampingan usaha</li>
                        <li><i class="fas fa-check-circle"></i>Perlindungan asuransi anggota</li>
                        <li><i class="fas fa-check-circle"></i>Mendapatkan bagi hasil (SHU) setiap tahun</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ============================================================
             ALUR PENDAFTARAN
             ============================================================ -->
        <div class="mt-40">
            <div class="text-center max-w-narrow mb-40 reveal-group">
                <h2 class="section-title">
                    Alur <span class="highlight">Pendaftaran</span>
                    <span class="decoration"></span>
                </h2>
                <p class="section-subtitle">Langkah-langkah menjadi anggota <?php echo htmlspecialchars($nama_koperasi); ?></p>
            </div>

            <div class="steps reveal-group">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4>Konsultasi</h4>
                    <p>Konsultasikan kebutuhan Anda dengan petugas kami</p>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4>Isi Formulir</h4>
                    <p>Lengkapi formulir pendaftaran anggota</p>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4>Verifikasi</h4>
                    <p>Petugas akan memverifikasi data dan dokumen Anda</p>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <h4>Aktif</h4>
                    <p>Setelah disetujui, Anda resmi menjadi anggota</p>
                </div>
            </div>
        </div>

        <!-- ============================================================
             CTA - DAFTAR SEKARANG
             ============================================================ -->
        <div class="mt-40 text-center">
            <div class="cta-card">
                <h3>Siap Menjadi Anggota?</h3>
                <p>Daftarkan diri Anda sekarang dan nikmati berbagai layanan unggulan dari <?php echo htmlspecialchars($nama_koperasi); ?></p>
                <a href="kontak.php" class="btn">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
