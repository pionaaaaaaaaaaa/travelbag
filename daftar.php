<?php
require_once 'config/database.php';
require_once 'config/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = false;
$data = ['nama' => '', 'email' => '', 'telepon' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nama'] = sanitize($_POST['nama'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['telepon'] = sanitize($_POST['telepon'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi'] ?? '';

    // Validasi
    if (!$data['nama'] || !$data['email'] || !$password) {
        $error = 'Nama, email, dan password wajib diisi.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($password !== $konfirmasi) {
        $error = 'Konfirmasi password tidak cocok.';
    } else {
        $db = getDB();

        // Cek email duplikat
        $chk = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $chk->execute([$data['email']]);
        if ($chk->fetch()) {
            $error = 'Email sudah terdaftar. Silakan login atau gunakan email lain.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $ins = $db->prepare(
                "INSERT INTO users (nama, email, password, telepon) VALUES (?, ?, ?, ?)"
            );
            $ins->execute([$data['nama'], $data['email'], $hash, $data['telepon']]);

            // Auto-login setelah daftar
            $userId = $db->lastInsertId();
            loginUser([
                'id' => $userId,
                'nama' => $data['nama'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
            ]);
            header('Location: index.php?welcome=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Travel Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: var(--secondary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 16px 70px;
        }

        .auth-card {
            width: 100%;
            max-width: 500px;
            background: var(--bg-surface);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary), var(--primary));
            padding: 40px 40px 36px;
            text-align: center;
        }

        .auth-header-logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
            margin-bottom: 14px;
            filter: brightness(0) invert(1);
            opacity: .9;
        }

        .auth-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--bg-surface);
            margin: 0 0 4px;
        }

        .auth-header p {
            font-size: 13px;
            color: var(--border-light);
            margin: 0;
        }

        .auth-body {
            padding: 36px 40px 40px;
        }

        .auth-label {
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .6px;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .auth-input-wrap {
            position: relative;
            margin-bottom: 20px;
        }

        .auth-input-wrap .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
            pointer-events: none;
        }

        .auth-input-wrap .form-control-custom {
            padding-left: 40px;
            width: 100%;
        }

        .auth-input-wrap .pass-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 15px;
        }

        .auth-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 480px) {
            .auth-row {
                grid-template-columns: 1fr;
            }
        }

        .auth-error {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 12px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--shadow-light);
        }

        .auth-footer-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 24px;
        }

        .auth-footer-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: color .2s;
        }

        .auth-footer-link a:hover {
            color: var(--primary);
        }

        .btn-auth {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: var(--bg-surface);
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .5px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px var(--shadow-medium);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            background: var(--primary);
            box-shadow: 0 8px 24px var(--shadow-dark);
        }

        .password-hint {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: -14px;
            margin-bottom: 20px;
        }

        .terms-note {
            font-size: 12px;
            color: var(--text-muted);
            text-align: center;
            margin-top: 20px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="page-header" style="background:var(--secondary)">
        <div class="container">
            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Daftar</li>
                </ol>
            </nav>
            <h1 class="page-header-title mt-2">Daftar</h1>
            <p class="page-header-sub">Daftar untuk interaksi dengan kami.</p>
        </div>
    </div>

    <div class="auth-wrapper">
        <div class="auth-card">

            <div class="auth-header">
                <img src="assets/images/logo.png" alt="Travel Bag" class="auth-header-logo">
                <h1>Buat Akun Baru</h1>
                <p>Daftarkan diri Anda dan nikmati layanan premium</p>
            </div>

            <div class="auth-body">

                <?php if ($error): ?>
                    <div class="auth-error">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" novalidate>

                    <!-- Nama -->
                    <label class="auth-label">Nama Lengkap</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nama" class="form-control form-control-custom"
                            placeholder="Nama lengkap Anda" value="<?= htmlspecialchars($data['nama']) ?>" required
                            autocomplete="name">
                    </div>

                    <!-- Email & Telepon -->
                    <div class="auth-row">
                        <div>
                            <label class="auth-label">Email</label>
                            <div class="auth-input-wrap" style="margin-bottom:0;">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control form-control-custom"
                                    placeholder="email@contoh.com" value="<?= htmlspecialchars($data['email']) ?>"
                                    required autocomplete="email">
                            </div>
                        </div>
                        <div>
                            <label class="auth-label">Telepon <span
                                    style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-muted);">(opsional)</span></label>
                            <div class="auth-input-wrap" style="margin-bottom:0;">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" name="telepon" class="form-control form-control-custom"
                                    placeholder="+62 8xx xxxx" value="<?= htmlspecialchars($data['telepon']) ?>"
                                    autocomplete="tel">
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom:20px;"></div>

                    <!-- Password -->
                    <label class="auth-label">Password</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="regPassword" class="form-control form-control-custom"
                            placeholder="Minimal 6 karakter" required autocomplete="new-password">
                        <button type="button" class="pass-toggle" onclick="togglePass('regPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="password-hint"><i class="fas fa-info-circle me-1"></i>Gunakan minimal 6 karakter dengan
                        kombinasi huruf dan angka.</p>

                    <!-- Konfirmasi Password -->
                    <label class="auth-label">Konfirmasi Password</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="konfirmasi" id="regKonfirmasi"
                            class="form-control form-control-custom" placeholder="Ulangi password" required
                            autocomplete="new-password">
                        <button type="button" class="pass-toggle" onclick="togglePass('regKonfirmasi', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </button>

                    <!-- <p class="terms-note">
                        Dengan mendaftar, Anda menyetujui <a href="#" style="color:var(--primary);font-weight:600;">Syarat & Ketentuan</a>
                        dan <a href="#" style="color:var(--primary);font-weight:600;">Kebijakan Privasi</a> kami.
                    </p> -->
                </form>

                <div class="auth-divider">atau</div>

                <div class="auth-footer-link">
                    Sudah punya akun? <a href="login.php">Masuk Sekarang</a>
                </div>

            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        function togglePass(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>