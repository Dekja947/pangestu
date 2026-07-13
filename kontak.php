<?php
/**
 * Halaman Kontak - Native CSS (style.css)
 */
$page_title = 'Kontak - Koperasi Sedio Makmur Mandiri';
require_once 'config/db.php';

// Ambil data settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$nama_koperasi = $settings['nama_koperasi'] ?? 'Koperasi Sedio Makmur Mandiri';
$alamat = $settings['alamat'] ?? 'Jl. Raya Pringsewu No. 123, Kabupaten Pringsewu, Lampung';
$telepon = $settings['telepon'] ?? '0729-123456';
$email = $settings['email'] ?? 'koperasi.smm@email.com';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email_post = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    $errors = [];
    if (empty($nama)) $errors[] = 'Nama harus diisi';
    if (empty($email_post) || !filter_var($email_post, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid';
    if (empty($pesan)) $errors[] = 'Pesan harus diisi';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO kontak_masuk (nama, email, pesan) VALUES (?, ?, ?)");
            $stmt->execute([$nama, $email_post, $pesan]);
            $success = 'Pesan Anda berhasil dikirim. Terima kasih!';
            $_POST = [];
        } catch (PDOException $e) {
            $error = 'Gagal mengirim pesan. Silakan coba lagi.';
        }
    } else {
        $error = implode(' ', $errors);
    }
}

include 'includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator">/</span>
        <span class="current">Kontak</span>
    </div>
</div>

<!-- Kontak Content -->
<section class="why-join">
    <div class="container">
        <!-- Header -->
        <div class="text-center reveal-group max-w-narrow mb-40">
            <h1 class="section-title">
                <span class="highlight">Kontak</span> Kami
                <span class="decoration"></span>
            </h1>
            <p class="section-subtitle">Kami siap melayani Anda. Hubungi kami melalui formulir di bawah ini.</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success max-w-wide mb-20">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger max-w-wide mb-20">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Contact Grid -->
        <div class="contact-grid max-w-wide">
            <!-- Contact Info -->
            <div>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Alamat</h4>
                        <p><?php echo htmlspecialchars($alamat); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <h4>Telepon</h4>
                        <p><?php echo htmlspecialchars($telepon); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <h4>Email</h4>
                        <p class="break-word"><?php echo htmlspecialchars($email); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <h4>Jam Operasional</h4>
                        <p>Senin-Jumat: 08.00 - 16.00 WIB</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h3><i class="fas fa-paper-plane"></i>Kirim Pesan</h3>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama"
                               value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                               placeholder="Masukkan alamat email Anda">
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="5"
                                  placeholder="Tulis pesan Anda di sini..."><?php echo htmlspecialchars($_POST['pesan'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pesan
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Map -->
        <div class="map-container max-w-wide">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.26693933314!2d104.81915051711987!3d-5.4598471453695215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e415f1c833f9a1f%3A0xb2b1c9c1f0f3f2e7!2sPringsewu%2C%20Kabupaten%20Pringsewu%2C%20Lampung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
