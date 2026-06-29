<?php
// =====================================================
// Auth Helper — Koper Website
// =====================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Cek apakah user sudah login */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
}

/** Ambil data user yang sedang login */
function getUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

/** Paksa login: redirect jika belum login */
function requireLogin(string $redirect = 'login.php'): void
{
    if (!isLoggedIn()) {
        $current = urlencode($_SERVER['REQUEST_URI']);
        header("Location: {$redirect}?next={$current}");
        exit;
    }
}

/** Set session user setelah berhasil login */
function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id'     => $user['id'],
        'nama'   => $user['nama'],
        'email'  => $user['email'],
        'telepon'=> $user['telepon'] ?? '',
    ];
}

/** Hapus session (logout) */
function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}
