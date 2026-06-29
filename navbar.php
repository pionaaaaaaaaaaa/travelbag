<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once 'config/auth.php';

$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
$currentPage = basename($_SERVER['PHP_SELF']);
$loggedIn = isLoggedIn();
$user = getUser();
?>
<link rel="shortcut icon" href="/../favicon.ico" type="image/x-icon">
<link href="assets/css/style.css?=103" rel="stylesheet">



<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNavbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <div class="brand-logo">
                <img src="assets/images/logo.png" alt="Travel Bag" class="brand-image">
                <div class="brand-text">
                    <span class="brand-name">Travel Bag</span>
                    <span class="brand-tagline">Premium Luggage</span>
                </div>
            </div>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Menu -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $currentPage === 'produk.php' ? 'active' : '' ?>" href="#"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-suitcase me-1"></i>Produk
                    </a>
                    <ul class="dropdown-menu dropdown-menu-custom">
                        <li><a class="dropdown-item" href="produk.php"><i class="fas fa-th me-2"></i>Semua Produk</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="produk.php?kategori=kabin"><i
                                    class="fas fa-plane me-2"></i>Koper Kabin</a></li>
                        <li><a class="dropdown-item" href="produk.php?kategori=medium"><i
                                    class="fas fa-suitcase me-2"></i>Koper Medium</a></li>
                        <li><a class="dropdown-item" href="produk.php?kategori=besar"><i
                                    class="fas fa-suitcase-rolling me-2"></i>Koper Besar</a></li>
                        <li><a class="dropdown-item" href="produk.php?kategori=set"><i
                                    class="fas fa-layer-group me-2"></i>Koper Set</a></li>
                        <li><a class="dropdown-item" href="produk.php?kategori=aksesoris"><i
                                    class="fas fa-tag me-2"></i>Aksesoris</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'tentang.php' ? 'active' : '' ?>" href="tentang.php">
                        <i class="fas fa-info-circle me-1"></i>Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'kontak.php' ? 'active' : '' ?>" href="kontak.php">
                        <i class="fas fa-envelope me-1"></i>Kontak
                    </a>
                </li>
            </ul>

            <!-- Navbar Right -->
            <div class="navbar-right d-flex align-items-center gap-2">
                <!-- Search -->
                <div class="nav-search-wrapper">
                    <button class="nav-icon-btn" id="searchToggle">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="nav-search-box" id="searchBox">
                        <form action="produk.php" method="GET">
                            <input type="text" name="cari" class="search-input" placeholder="Cari koper...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <?php if ($loggedIn): ?>
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="nav-icon-btn d-flex align-items-center gap-2 px-3"
                            style="width:fit-content;border-radius:50px;border:1.5px solid var(--border-light);font-size:13px;font-weight:600;letter-spacing:.3px;"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div
                                style="width:28px;height:28px;background:var(--bg-surface);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--text-main);font-size:12px;font-weight:800;flex-shrink:0;">
                                <?= strtoupper(mb_substr($user['nama'], 0, 1)) ?>
                            </div>
                            <span class="d-none d-lg-inline"><?= htmlspecialchars(explode(' ', $user['nama'])[0]) ?></span>
                            <i class="fas fa-chevron-down" style="font-size:10px;opacity:.7;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom mt-2" style="min-width:200px;">
                            <li>
                                <div class="px-3 py-2" style="border-bottom:1px solid var(--shadow-light);">
                                    <div style="font-size:13px;font-weight:700;color:var(--primary);">
                                        <?= htmlspecialchars($user['nama']) ?>
                                    </div>
                                    <div style="font-size:11.5px;color:var(--text-main);">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="kontak.php">
                                    <i class="fas fa-envelope me-2"></i>Kirim Pesan
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="logout.php" style="color:var(--danger-badge);"
                                    onclick="return confirm('Yakin ingin keluar?')">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Login & Daftar -->
                    <a href="login.php" class="nav-icon-btn d-flex align-items-center gap-1 px-3"
                        style="border-radius:50px;border:1.5px solid var(--border-light);font-size:13px;font-weight:600;text-decoration:none;color:var(--secondary); width: 90px;">
                        <i class="fas fa-sign-in-alt" style="font-size:14px;"></i>
                        <span class="d-none d-sm-inline">Masuk</span>
                    </a>
                    <a href="daftar.php" class="d-none d-lg-flex align-items-center gap-1 px-3 py-2"
                        style="border-radius:50px;background:var(--primary);color:var(--secondary);font-family:'Montserrat',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;letter-spacing:.3px;transition:var(--transition);box-shadow:0 2px 10px var(--shadow-medium);"
                        onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                        <i class="fas fa-user-plus" style="font-size:13px;"></i>Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-content">
        <form action="produk.php" method="GET">
            <input type="text" name="cari" class="search-overlay-input" placeholder="Cari koper premium...">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <button class="search-close" id="searchClose"><i class="fas fa-times"></i></button>
    </div>
</div>