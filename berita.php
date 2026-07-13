<?php
/**
 * Halaman Berita - Native CSS (style.css)
 * Menampilkan daftar seluruh berita & pengumuman, dengan filter kategori dan pagination.
 *
 * CATATAN: Halaman ini dibuat berdasarkan pola yang sudah konsisten dipakai di index.php
 * (query yang sama untuk tabel `berita`, dan komponen kartu .news-card yang sama),
 * karena file berita.php asli belum sempat diterima. Sesuaikan jika ada fitur berbeda
 * yang Anda inginkan (mis. pencarian, jumlah per halaman, dsb).
 */

$page_title = 'Berita - Sistem Informasi Profil Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// Ambil data settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';

// Filter kategori lewat ?kategori=berita atau ?kategori=pengumuman
$kategori_filter = $_GET['kategori'] ?? '';
$kategori_filter = in_array($kategori_filter, ['berita', 'pengumuman']) ? $kategori_filter : '';

// Pagination
$per_page = 9;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

// Hitung total data untuk pagination
if ($kategori_filter) {
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM berita WHERE status = 'publish' AND kategori = ?");
    $stmt_count->execute([$kategori_filter]);
} else {
    $stmt_count = $pdo->query("SELECT COUNT(*) FROM berita WHERE status = 'publish'");
}
$total_data = (int)$stmt_count->fetchColumn();
$total_pages = max(1, (int)ceil($total_data / $per_page));
$page = min($page, $total_pages);
$offset = ($page - 1) * $per_page;

// Ambil data berita untuk halaman ini
if ($kategori_filter) {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE status = 'publish' AND kategori = ? ORDER BY tanggal DESC LIMIT $per_page OFFSET $offset");
    $stmt->execute([$kategori_filter]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE status = 'publish' ORDER BY tanggal DESC LIMIT $per_page OFFSET $offset");
    $stmt->execute();
}
$berita_list = $stmt->fetchAll();

// Helper untuk membangun URL query string (mempertahankan filter kategori saat ganti halaman)
function berita_url($page_num, $kategori) {
    $params = ['page' => $page_num];
    if ($kategori) {
        $params['kategori'] = $kategori;
    }
    return 'berita.php?' . http_build_query($params);
}

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator">/</span>
        <span class="current">Berita</span>
    </div>
</div>

<!-- ============================================================
     HEADER SECTION
     ============================================================ -->
<section class="services">
    <div class="container">
        <div class="text-center max-w-narrow reveal-group">
            <h1 class="section-title">
                Berita & <span class="highlight">Pengumuman</span>
                <span class="decoration"></span>
            </h1>
            <p class="section-subtitle">
                Informasi dan kabar terbaru seputar kegiatan <?php echo htmlspecialchars($nama_koperasi); ?>
            </p>
        </div>
    </div>
</section>

<!-- ============================================================
     DAFTAR BERITA
     ============================================================ -->
<section class="why-join">
    <div class="container">

        <!-- Filter Kategori -->
        <div class="filter-tabs">
            <a href="berita.php" class="<?php echo $kategori_filter === '' ? 'active' : ''; ?>">Semua</a>
            <a href="berita.php?kategori=berita" class="<?php echo $kategori_filter === 'berita' ? 'active' : ''; ?>">Berita</a>
            <a href="berita.php?kategori=pengumuman" class="<?php echo $kategori_filter === 'pengumuman' ? 'active' : ''; ?>">Pengumuman</a>
        </div>

        <?php if (count($berita_list) > 0): ?>
            <div class="news-grid reveal-group">
                <?php foreach ($berita_list as $berita): ?>
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
                            <h3 class="line-clamp-2"><a href="berita-detail.php?id=<?php echo $berita['id']; ?>"><?php echo htmlspecialchars($berita['judul']); ?></a></h3>
                            <p class="line-clamp-2"><?php echo htmlspecialchars(substr(strip_tags($berita['isi']), 0, 120)); ?>...</p>
                            <a href="berita-detail.php?id=<?php echo $berita['id']; ?>" class="read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <a href="<?php echo berita_url(max(1, $page - 1), $kategori_filter); ?>" class="<?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="<?php echo berita_url($i, $kategori_filter); ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <a href="<?php echo berita_url(min($total_pages, $page + 1), $kategori_filter); ?>" class="<?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state bordered">
                <i class="fas fa-newspaper"></i>
                <p>Belum ada berita<?php echo $kategori_filter ? ' pada kategori ini' : ''; ?>.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
