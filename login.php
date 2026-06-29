<?php
require_once 'config/database.php';
require_once 'config/auth.php';

// Sudah login? redirect
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error  = '';
$email  = '';
$next   = htmlspecialchars($_GET['next'] ?? 'index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Email dan password wajib diisi.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND aktif = 1 LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            loginUser($user);
            $redirect = filter_var($next, FILTER_SANITIZE_URL);
            // pastikan redirect masih di domain yang sama
            if (!$redirect || strpos($redirect, '/') !== 0) {
                $redirect = 'index.php';
            }
            header("Location: $redirect");
            exit;
        } else {
            $error = 'Email atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Travel Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* ── Auth Layout ── */
        body { background: var(--secondary); min-height: 100vh; display: flex; flex-direction: column; }

        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 16px 70px;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
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
            width: 72px;
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

        .auth-footer-link a:hover { color: var(--primary); }

        .auth-error {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
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

        .forgot-link {
            text-align: right;
            font-size: 12px;
            margin-top: -14px;
            margin-bottom: 20px;
        }

        .forgot-link a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }

        .forgot-link a:hover { color: var(--primary); }

        /* breadcrumb fix posisi */
        .auth-breadcrumb {
            padding: 88px 0 0;
            background: transparent;
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
                    <li class="breadcrumb-item active">Login</li>
                </ol>
            </nav>
            <h1 class="page-header-title mt-2">Login</h1>
            <p class="page-header-sub">Masuk untuk interaksi dengan kami.</p>
        </div>
    </div>

    <div class="auth-wrapper">
        <div class="auth-card">

            <!-- Header -->
            <div class="auth-header">
                <img src="assets/images/logo.png" alt="Travel Bag" class="auth-header-logo">
                <h1>Selamat Datang</h1>
                <p>Masuk ke akun Travel Bag Anda</p>
            </div>

            <!-- Body -->
            <div class="auth-body">

                <?php if ($error): ?>
                    <div class="auth-error">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" novalidate>
                    <input type="hidden" name="next" value="<?= $next ?>">

                    <!-- Email -->
                    <label class="auth-label">Email</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            class="form-control form-control-custom"
                            placeholder="email@contoh.com"
                            value="<?= htmlspecialchars($email) ?>"
                            required
                            autocomplete="email">
                    </div>

                    <!-- Password -->
                    <label class="auth-label">Password</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="loginPassword"
                            class="form-control form-control-custom"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password">
                        <button type="button" class="pass-toggle" onclick="togglePass('loginPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- <div class="forgot-link">
                        <a href="#">Lupa password?</a>
                    </div> -->

                    <button type="submit" class="btn-auth">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                    </button>
                </form>

                <div class="auth-divider">atau</div>

                <div class="auth-footer-link">
                    Belum punya akun? <a href="daftar.php">Daftar Sekarang</a>
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
            const icon  = btn.querySelector('i');
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