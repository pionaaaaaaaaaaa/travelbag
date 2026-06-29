<?php
require_once 'config/database.php';
require_once 'config/auth.php';

$db     = getDB();
$sukses = false;
$error  = '';

// Ambil data user jika sudah login
$loggedIn  = isLoggedIn();
$userEmail = $loggedIn ? getUser()['email'] : '';
$userNama  = $loggedIn ? getUser()['nama']  : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$loggedIn) {
        $error = 'Anda harus login terlebih dahulu untuk mengirim pesan.';
    } else {
        $nama   = sanitize($_POST['nama']  ?? '');
        $email  = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $subjek = sanitize($_POST['subjek'] ?? '');
        $pesan  = sanitize($_POST['pesan']  ?? '');

        if ($nama && $email && $subjek && $pesan) {
            $stmt = $db->prepare(
                "INSERT INTO kontak (nama, email, subjek, pesan, user_id) VALUES (?,?,?,?,?)"
            );
            $stmt->execute([$nama, $email, $subjek, $pesan, getUser()['id']]);
            $sukses = true;
        } else {
            $error = 'Semua field wajib diisi dengan benar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak — LuxeTravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* ── Lock Overlay ── */
        .form-lock-wrapper { position: relative; }

        .form-lock-overlay {
            position: absolute;
            inset: 0;
            background: rgba(245, 239, 235, 0.85);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: var(--radius-lg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 10;
        }

        .lock-icon-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--primary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px var(--shadow-medium);
        }

        .lock-icon-circle i { color: var(--bg-surface); font-size: 26px; }

        .lock-label {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .lock-sub {
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
            max-width: 240px;
            line-height: 1.5;
        }

        .btn-lock-login {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 32px;
            background: linear-gradient(135deg, var(--bg-surface), var(--primary));
            color: var(--text-main);
            border: none;
            border-radius: 50px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 16px var(--shadow-medium);
            transition: var(--transition);
        }

        .btn-lock-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--shadow-dark);
            color: var(--text-main);
        }

        .lock-daftar {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .lock-daftar a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        /* disabled look on form when locked */
        .form-locked { pointer-events: none; user-select: none; }
        .form-locked input,
        .form-locked select,
        .form-locked textarea,
        .form-locked button { opacity: .45; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="page-header" style="background:var(--secondary)">
        <div class="container">
            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Kontak</li>
                </ol>
            </nav>
            <h1 class="page-header-title mt-2">Hubungi Kami</h1>
            <p class="page-header-sub">Kami siap membantu Anda 6 hari seminggu</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-5">
            <!-- Info Kontak -->
            <div class="col-lg-4" data-aos="fade-right">
                <div style="background:linear-gradient(135deg,var(--primary),var(--primary));border-radius:var(--radius-xl);padding:40px;color:white;height:100%;">
                    <div style="font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;margin-bottom:8px;">
                        Kami Ada<br><span style="color:var(--bg-surface);">Untuk Anda</span></div>
                    <p style="color:var(--border-light);font-size:13.5px;margin-bottom:32px;">Tim kami siap membantu
                        menjawab pertanyaan dan kebutuhan Anda seputar koper premium.</p>
                    <div class="kontak-info-item" style="border-color:var(--border-light);">
                        <div class="kontak-info-icon" style="background:var(--border-light);color:var(--bg-surface);"><i class="fas fa-map-marker-alt"></i></div>
                        <div><strong style="font-size:13px;display:block;margin-bottom:4px;">Alamat</strong><span style="font-size:13px;color:var(--border-light);">Jl. pentol</span></div>
                    </div>
                    <!-- <div class="kontak-info-item" style="border-color:var(--border-light);">
                        <div class="kontak-info-icon" style="background:var(--border-light);color:var(--bg-surface);"><i class="fas fa-phone-alt"></i></div>
                        <div><strong style="font-size:13px;display:block;margin-bottom:4px;">Telepon</strong><span style="font-size:13px;color:var(--border-light);">+62 878 1183 8864</span></div>
                    </div>
                    <div class="kontak-info-item" style="border-color:var(--border-light);">
                        <div class="kontak-info-icon" style="background:var(--border-light);color:var(--bg-surface);"><i class="fab fa-whatsapp"></i></div>
                        <div><strong style="font-size:13px;display:block;margin-bottom:4px;">WhatsApp</strong><span style="font-size:13px;color:var(--border-light);">+62 878 1183 8864</span></div>
                    </div> -->
                    <div class="kontak-info-item" style="border-color:var(--border-light);">
                        <div class="kontak-info-icon" style="background:var(--border-light);color:var(--bg-surface);"><i class="fas fa-envelope"></i></div>
                        <div><strong style="font-size:13px;display:block;margin-bottom:4px;">Email</strong><span style="font-size:13px;color:var(--border-light);">hello@BagTravel.com</span></div>
                    </div>
                    <div class="kontak-info-item" style="border:none;">
                        <div class="kontak-info-icon" style="background:var(--border-light);color:var(--bg-surface);"><i class="fas fa-clock"></i></div>
                        <div><strong style="font-size:13px;display:block;margin-bottom:4px;">Jam Operasional</strong><span style="font-size:13px;color:var(--border-light);">Sen - Sab: 09.00 - 18.00 WIB</span></div>
                    </div>
                </div>
            </div>

            <!-- Form Kontak -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="kontak-card form-lock-wrapper">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--primary);margin-bottom:8px;">Kirim Pesan</h3>
                    <p style="color:var(--text-muted);font-size:14px;margin-bottom:32px;">Isi formulir di bawah dan kami akan membalas dalam 1x24 jam.</p>

                    <?php if ($sukses): ?>
                        <div class="alert border-0 mb-4" style="background:var(--success-bg);color:var(--success-text);border-radius:12px;padding:16px 20px;">
                            <i class="fas fa-check-circle me-2"></i><strong>Pesan berhasil dikirim!</strong> Kami akan membalas secepatnya.
                        </div>
                    <?php elseif ($error): ?>
                        <div class="alert border-0 mb-4" style="background:var(--danger-bg);color:var(--danger-text);border-radius:12px;padding:16px 20px;">
                            <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form (disabled visual saat belum login) -->
                    <form method="POST" class="<?= !$loggedIn ? 'form-locked' : '' ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label style="font-size:12px;font-weight:600;color:var(--primary);letter-spacing:0.5px;margin-bottom:8px;display:block;">NAMA LENGKAP *</label>
                                <input type="text" name="nama" class="form-control form-control-custom"
                                    placeholder="John Doe"
                                    value="<?= htmlspecialchars($userNama) ?>"
                                    <?= $loggedIn ? '' : 'disabled' ?> required>
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px;font-weight:600;color:var(--primary);letter-spacing:0.5px;margin-bottom:8px;display:block;">EMAIL *</label>
                                <input type="email" name="email" class="form-control form-control-custom"
                                    placeholder="email@contoh.com"
                                    value="<?= htmlspecialchars($userEmail) ?>"
                                    <?= $loggedIn ? 'readonly' : 'disabled' ?> required>
                            </div>
                            <div class="col-12">
                                <label style="font-size:12px;font-weight:600;color:var(--primary);letter-spacing:0.5px;margin-bottom:8px;display:block;">SUBJEK *</label>
                                <select name="subjek" class="form-control form-control-custom" <?= $loggedIn ? '' : 'disabled' ?> required>
                                    <option value="">Pilih subjek...</option>
                                    <option>Pertanyaan Produk</option>
                                    <option>Status Pesanan</option>
                                    <option>Klaim Garansi</option>
                                    <option>Kemitraan / Reseller</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label style="font-size:12px;font-weight:600;color:var(--primary);letter-spacing:0.5px;margin-bottom:8px;display:block;">PESAN *</label>
                                <textarea name="pesan" class="form-control form-control-custom" rows="5"
                                    placeholder="Tulis pesan Anda di sini..."
                                    <?= $loggedIn ? '' : 'disabled' ?> required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" style="color:var(--secondary);" class="btn-primary-custom" <?= $loggedIn ? '' : 'disabled' ?>>
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- LOCK OVERLAY — hanya tampil jika belum login -->
                    <?php if (!$loggedIn): ?>
                    <div class="form-lock-overlay">
                        <div class="lock-icon-circle">
                            <i class="fas fa-lock"></i>
                        </div>
                        <span class="lock-label">Form Terkunci</span>
                        <p class="lock-sub">Login terlebih dahulu untuk mengirimkan pesan kepada kami.</p>
                        <a href="login.php?next=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn-lock-login">
                            <i class="fas fa-sign-in-alt"></i>Login Untuk Mengirim Pesan
                        </a>
                        <p class="lock-daftar">Belum punya akun? <a href="daftar.php">Daftar Gratis</a></p>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>AOS.init({ once: true });</script>
</body>
</html>
