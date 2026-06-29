<?php
require_once 'config/database.php';
require_once 'config/auth.php';

$db = getDB();

$loggedIn  = isLoggedIn();
$userEmail = $loggedIn ? getUser()['email'] : '';
$userNama  = $loggedIn ? getUser()['nama']  : '';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $db->prepare("SELECT p.*, k.nama as kategori_nama, k.slug as kategori_slug FROM produk p JOIN kategori k ON p.kategori_id = k.id WHERE p.id = ? AND p.aktif = 1");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    header('Location: produk.php');
    exit;
}

// Ulasan
$stmtUl = $db->prepare("SELECT * FROM ulasan WHERE produk_id = ? ORDER BY id DESC LIMIT 5");
$stmtUl->execute([$id]);
$ulasans = $stmtUl->fetchAll();

// Produk terkait
$stmtRel = $db->prepare("SELECT p.*, k.nama as kategori_nama FROM produk p JOIN kategori k ON p.kategori_id = k.id WHERE p.kategori_id = ? AND p.id != ? AND p.aktif = 1 LIMIT 3");
$stmtRel->execute([$produk['kategori_id'], $id]);
$terkait = $stmtRel->fetchAll();

// Tambah ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ulasan'])) {
    if (!$loggedIn) {
        header("Location: login.php?next=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
    $nama    = $userNama; // pakai nama dari session
    $rating  = (int) $_POST['rating'];
    $komentar = sanitize($_POST['komentar']);
    if ($nama && $rating >= 1 && $rating <= 5 && $komentar) {
        $ins = $db->prepare(
            "INSERT INTO ulasan (produk_id, nama, rating, komentar, user_id) VALUES (?, ?, ?, ?, ?)"
        );
        $ins->execute([$id, $nama, $rating, $komentar, getUser()['id']]);
        header("Location: detail.php?id=$id&ulasan=ok");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['nama']) ?> — LuxeTravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Breadcrumb -->
    <div class="page-header" style="padding: 140px 0 40px; background:var(--secondary)">
        <div class="container">
            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="produk.php">Produk</a></li>
                    <li class="breadcrumb-item"><a
                            href="produk.php?kategori=<?= $produk['kategori_slug'] ?>"><?= $produk['kategori_nama'] ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?= $produk['nama'] ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <?php if (isset($_GET['ulasan'])): ?>
            <div class="alert alert-success border-0 mb-4" style="background:var(--success-bg); color:var(--success-text); border-radius:12px;">
                <i class="fas fa-check-circle me-2"></i> Ulasan berhasil dikirim. Terima kasih!
            </div>
        <?php endif; ?>

        <div class="row g-5">
            <!-- Image -->
            <div class="col-lg-5">
                <div class="detail-image-wrap">
                    <!-- <?php if ($produk['badge']): ?>
                    <div class="detail-badge badge-<?= strtolower($produk['badge']) ?>"><?= $produk['badge'] ?></div>
                    <?php endif; ?> -->
                    <img src="<?= 'assets/images/produk/' . preg_replace('/\.(jpg|jpeg|png)$/i', '.png', $produk['gambar']) ?>"
                        alt="<?= htmlspecialchars($produk['nama']) ?>" class="detail-img-real">
                </div>
                <!-- Thumbnails simulasi -->
                <!-- <div class="d-flex gap-2 mt-3 justify-content-center">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <div style="width:64px; height:64px; background: linear-gradient(135deg, var(--primary), var(--primary)); border-radius:10px; display:flex; align-items:center; justify-content:center; cursor:pointer; border: 2px solid <?= $i === 1 ? 'var(--primary-hover)' : 'transparent' ?>;">
                    <i class="fas fa-suitcase-rolling" style="color:var(--bg-surface); font-size:28px;"></i>
                </div>
                <?php endfor; ?>
            </div> -->
            </div>

            <!-- Info -->
            <div class="col-lg-7">
                <div class="produk-kategori mb-2"><?= $produk['kategori_nama'] ?></div>
                <h1
                    style="font-family:'Cormorant Garamond',serif; font-size:clamp(24px,3vw,38px); color:var(--primary); font-weight:700; line-height:1.2; margin-bottom:16px;">
                    <?= $produk['nama'] ?>
                </h1>

                <!-- Rating -->
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stars text-warning"><?= renderBintang($produk['rating']) ?></div>
                    <span class="text-muted" style="font-size:13px;"><?= $produk['rating'] ?>/5
                        </span>
                    <!-- <span
                        style="color:<?= $produk['stok'] > 0 ? 'var(--success-badge)' : 'var(--danger-badge)' ?>; font-size:13px; font-weight:600;">
                        <i class="fas fa-circle me-1" style="font-size:8px;"></i>
                        <?= $produk['stok'] > 0 ? 'Stok Tersedia (' . $produk['stok'] . ' pcs)' : 'Habis' ?>
                    </span> -->
                </div>

                <!-- Harga -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span
                        style="font-family:'Cormorant Garamond',serif; font-size:38px; font-weight:800; color:var(--primary);">
                        <?= formatRupiah($produk['harga']) ?>
                    </span>
                    <?php if ($produk['harga_coret']):
                        $diskon = round((($produk['harga_coret'] - $produk['harga']) / $produk['harga_coret']) * 100);
                    ?>
                        <div>
                            <div class="harga-coret"><?= formatRupiah($produk['harga_coret']) ?></div>
                            <div class="produk-diskon">Hemat <?= $diskon ?>% 🔥</div>
                        </div>
                    <?php endif; ?>
                </div>

                <p style="font-size:14.5px; line-height:1.75; color:var(--text-main); margin-bottom:28px;">
                    <?= nl2br(htmlspecialchars($produk['deskripsi'])) ?>
                </p>

                <!-- Spesifikasi -->
                <div class="detail-info-card mb-4">
                    <h6
                        style="font-size:13px; font-weight:700; color:var(--primary); margin-bottom:16px; letter-spacing:1px; text-transform:uppercase;">
                        <i class="fas fa-info-circle me-2 text-royal"></i>Spesifikasi
                    </h6>
                    <div class="spec-grid">
                        <div class="spec-item"><span class="spec-label">Berat</span><span
                                class="spec-value"><?= $produk['berat'] ?: '-' ?></span></div>
                        <div class="spec-item"><span class="spec-label">Dimensi</span><span
                                class="spec-value"><?= $produk['dimensi'] ?: '-' ?></span></div>
                        <div class="spec-item"><span class="spec-label">Material</span><span
                                class="spec-value"><?= $produk['material'] ?: '-' ?></span></div>
                        <div class="spec-item"><span class="spec-label">Garansi</span><span
                                class="spec-value"><?= $produk['garansi'] ?: '-' ?></span></div>
                    </div>
                    <?php if ($produk['warna']): ?>
                        <div class="mt-3">
                            <div class="spec-label mb-1">Pilihan Warna</div>
                            <div class="d-flex gap-2 flex-wrap">
                                <?php foreach (explode(',', $produk['warna']) as $w): ?>
                                    <span
                                        style="font-size:12px; background:var(--light-blue); color:var(--primary-hover); padding:4px 10px; border-radius:50px; font-weight:500;">
                                        <?= trim($w) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Qty & Cart -->
                <?php if ($produk['stok'] > 0): ?>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <!-- <div class="qty-control">
                            <button class="qty-btn" data-action="minus">−</button>
                            <input type="number" class="qty-input" value="1" min="1" max="<?= $produk['stok'] ?>"
                                id="qtyInput">
                            <button class="qty-btn" data-action="plus">+</button>
                        </div>
                        <button class="btn-primary-custom" onclick="addToCartDetail()">
                            <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                        </button> -->
                        <?php
                        $shopeeLink = !empty($produk['link_shopee']) ? $produk['link_shopee'] : 'https://shopee.co.id/search?keyword=' . urlencode($produk['nama']);
                        ?>
                        <a href="<?= htmlspecialchars($shopeeLink) ?>" target="_blank" rel="noopener"
                            style="display:inline-flex;align-items:center;gap:10px;padding:13px 28px;border-radius:50px;background:linear-gradient(135deg,var(--warning-badge),var(--danger-badge));color:var(--bg-surface);font-weight:600;font-size:14px;letter-spacing:0.3px;text-decoration:none;box-shadow:0 4px 18px var(--shadow-medium);transition:all .25s cubic-bezier(.4,0,.2,1);"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px var(--shadow-dark)'"
                            onmouseout="this.style.transform='';this.style.boxShadow='0 4px 18px var(--shadow-medium)'">
                            <img src="assets/images/produk/shopee.png" alt="Shopee"
                                style="width:22px;height:22px;object-fit:contain;filter:brightness(0) invert(1);">
                            Beli di Shopee
                        </a>
                    </div>
                <?php else: ?>
                    <button class="btn-primary-custom" disabled style="opacity:0.5; cursor:not-allowed;">
                        <i class="fas fa-times me-2"></i>Stok Habis
                    </button>
                <?php endif; ?>

                <!-- Share -->
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span style="font-size:12px; color:var(--text-muted);">Bagikan:</span>
                    <a href="#" style="color:var(--primary); font-size:18px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="color:var(--success-badge); font-size:18px;"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" style="color:var(--danger-badge); font-size:18px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color:var(--primary); font-size:18px;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Ulasan -->
        <div class="row mt-5 g-4">
            <div class="col-lg-8">
                <h3 style="font-family:'Cormorant Garamond',serif; color:var(--primary); margin-bottom:24px;">
                    Ulasan Pembeli <span
                        style="font-size:16px; color:var(--text-muted); font-family:'Montserrat',sans-serif;">(<?= count($ulasans) ?>
                        ulasan)</span>
                </h3>
                <?php if (empty($ulasans)): ?>
                    <div class="empty-state" style="padding:40px;">
                        <i class="fas fa-comment-slash empty-icon"></i>
                        <p class="text-muted">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($ulasans as $u): ?>
                            <div class="testimoni-card" style="padding:20px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="author-avatar" style="width:36px;height:36px;font-size:14px;">
                                            <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                                        </div>
                                        <strong style="font-size:14px;"><?= htmlspecialchars($u['nama']) ?></strong>
                                    </div>
                                    <div class="stars text-warning" style="font-size:12px;"><?= renderBintang($u['rating']) ?>
                                    </div>
                                </div>
                                <p style="font-size:13.5px; color:var(--text-main); margin:0; line-height:1.6;">
                                    <?= htmlspecialchars($u['komentar']) ?>
                                </p>
                                <small class="text-muted"><?= date('d M Y', strtotime($u['created_at'])) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Form Ulasan -->
                <div class="mt-4 p-4" style="background:var(--bg-main); border-radius:var(--radius-lg); position:relative;">
                    <h5 style="font-weight:700; color:var(--primary); margin-bottom:20px;">
                        <i class="fas fa-pen me-2 text-royal"></i>Tulis Ulasan
                    </h5>

                    <!-- Form — disabled visual saat belum login -->
                    <form method="POST" class="<?= !$loggedIn ? 'form-locked' : '' ?>"
                        style="<?= !$loggedIn ? 'pointer-events:none;user-select:none;opacity:.45;' : '' ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="nama" class="form-control form-control-custom"
                                    placeholder="Nama Anda"
                                    value="<?= htmlspecialchars($userNama) ?>"
                                    <?= $loggedIn ? 'readonly' : 'disabled' ?> required>
                            </div>
                            <div class="col-md-6">
                                <select name="rating" class="form-control form-control-custom"
                                    <?= $loggedIn ? '' : 'disabled' ?> required>
                                    <option value="">Pilih Rating</option>
                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                                    <option value="4">⭐⭐⭐⭐ Puas</option>
                                    <option value="3">⭐⭐⭐ Cukup</option>
                                    <option value="2">⭐⭐ Kurang</option>
                                    <option value="1">⭐ Tidak Puas</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea name="komentar" class="form-control form-control-custom" rows="4"
                                    placeholder="Bagikan pengalaman Anda..."
                                    <?= $loggedIn ? '' : 'disabled' ?> required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="submit_ulasan" class="btn-primary-custom"
                                    <?= $loggedIn ? '' : 'disabled' ?>>
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- LOCK OVERLAY — hanya tampil jika belum login -->
                    <?php if (!$loggedIn): ?>
                        <div style="position:absolute;inset:0;background:rgba(245, 239, 235, 0.85);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);border-radius:var(--radius-lg);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;z-index:10;padding:24px;">
                            <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--primary),var(--primary));border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 24px var(--shadow-medium);">
                                <i class="fas fa-lock" style="color:var(--bg-surface);font-size:22px;"></i>
                            </div>
                            <span style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:700;color:var(--primary);">Ulasan Terkunci</span>
                            <p style="font-size:13px;color:var(--text-muted);text-align:center;max-width:220px;line-height:1.5;margin:0;">Login untuk berbagi pengalaman Anda dengan produk ini.</p>
                            <a href="login.php?next=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                                style="display:inline-flex;align-items:center;gap:8px;padding:11px 28px;background:linear-gradient(135deg,var(--bg-surface),var(--primary));color:var(--text-main);border-radius:50px;font-family:'Montserrat',sans-serif;font-size:13.5px;font-weight:700;text-decoration:none;box-shadow:0 4px 16px var(--shadow-medium);transition:var(--transition);"
                                onmouseover="this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.transform=''">
                                <i class="fas fa-sign-in-alt"></i>Login untuk Ulasan
                            </a>
                            <p style="font-size:12px;color:var(--text-muted);margin:0;">Belum punya akun? <a href="daftar.php" style="color:var(--primary);font-weight:700;text-decoration:none;">Daftar Gratis</a></p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Produk Terkait -->
            <div class="col-lg-4">
                <h3 style="font-family:'Cormorant Garamond',serif; color:var(--primary); margin-bottom:24px;">Produk
                    Terkait</h3>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($terkait as $t): ?>
                        <a href="detail.php?id=<?= $t['id'] ?>" style="text-decoration:none;">
                            <div class="d-flex gap-3 p-3 bg-white rounded-3 border border-light"
                                style="transition:all 0.3s;" onmouseover="this.style.borderColor='var(--primary-hover)'"
                                onmouseout="this.style.borderColor='var(--bg-main)'">
                                <div style="width:70px;height:70px;border-radius:12px;overflow:hidden;flex-shrink:0;">
                                    <img src="assets/images/produk/<?= htmlspecialchars($t['gambar']) ?>"
                                        alt="<?= htmlspecialchars($t['nama']) ?>"
                                        style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div>
                                    <div
                                        style="font-size:13px;font-weight:700;color:var(--primary);line-height:1.3;margin-bottom:4px;">
                                        <?= $t['nama'] ?>
                                    </div>
                                    <div class="stars text-warning" style="font-size:10px;margin-bottom:4px;">
                                        <?= renderBintang($t['rating']) ?>
                                    </div>
                                    <div style="font-size:14px;font-weight:800;color:var(--primary-hover);">
                                        <?= formatRupiah($t['harga']) ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        function addToCartDetail() {
            const qty = parseInt(document.getElementById('qtyInput').value) || 1;
            addToCart(<?= $produk['id'] ?>, '<?= addslashes($produk['nama']) ?>', <?= $produk['harga'] ?>, qty);
        }
    </script>
</body>

</html>