<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// session_start();
require_once 'config/database.php';
$db = getDB();

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];
$cart = $_SESSION['cart'];
$total = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart));
$ongkir = $total >= 500000 ? 0 : 25000;
$totalBayar = $total + $ongkir;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja — LuxeTravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="page-header" style="padding:140px 0 40px; background:var(--secondary)">
        <div class="container">
            <h1 class="page-header-title"><i class="fas fa-shopping-cart me-3"></i>Keranjang Belanja</h1>
            <p class="page-header-sub"><?= count($cart) ?> produk dalam keranjang</p>
        </div>
    </div>

    <div class="container py-5">
        <?php if (empty($cart)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-shopping-cart"></i></div>
                <h4 style="color:var(--primary);">Keranjang Anda Kosong</h4>
                <p class="text-muted">Tambahkan koper pilihan Anda ke keranjang</p>
                <a href="produk.php" class="btn-primary-custom mt-3 d-inline-flex">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <!-- Cart Table -->
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr class="cart-row" data-id="<?= $item['id'] ?>" data-harga="<?= $item['harga'] ?>">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    style="width:60px;height:60px;background:linear-gradient(135deg,var(--primary),var(--primary));border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="fas fa-suitcase-rolling"
                                                        style="color:var(--bg-surface);font-size:24px;"></i>
                                                </div>
                                                <div class="cart-product-name"><?= htmlspecialchars($item['nama']) ?></div>
                                            </div>
                                        </td>
                                        <td style="font-size:14px;font-weight:600;color:var(--primary);">
                                            <?= formatRupiah($item['harga']) ?>
                                        </td>
                                        <td>
                                            <div class="qty-control">
                                                <button class="qty-btn" data-action="minus">−</button>
                                                <input type="number" class="qty-input" value="<?= $item['qty'] ?>" min="1"
                                                    max="99" onchange="updateCart(<?= $item['id'] ?>, this.value)">
                                                <button class="qty-btn" data-action="plus">+</button>
                                            </div>
                                        </td>
                                        <td class="subtotal" style="font-size:15px;font-weight:800;color:var(--primary-hover);">
                                            <?= formatRupiah($item['harga'] * $item['qty']) ?>
                                        </td>
                                        <td>
                                            <button onclick="removeFromCart(<?= $item['id'] ?>)"
                                                style="background:none;border:none;color:var(--danger-badge);font-size:16px;cursor:pointer;padding:8px;"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="produk.php" class="btn-outline-custom"
                            style="font-size:13px; padding:10px 20px; border-color:var(--primary-hover); color:var(--primary-hover);">
                            <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                        </a>
                        <div style="font-size:13px;color:var(--text-muted);">
                            <i class="fas fa-truck me-1 text-success"></i>
                            <?= $ongkir == 0 ? 'Selamat! Anda mendapat <strong>gratis ongkir</strong>' : 'Belanja min. Rp 500.000 untuk gratis ongkir' ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary-card">
                        <h5
                            style="font-family:'Cormorant Garamond',serif;font-size:24px;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--border-light);">
                            Ringkasan Pesanan
                        </h5>
                        <div class="summary-total">
                            <div class="summary-row">
                                <span style="font-size:13px;color:var(--border-light);">Subtotal (<?= count($cart) ?>
                                    item)</span>
                                <span id="cartTotal"
                                    style="font-size:14px;font-weight:600;"><?= formatRupiah($total) ?></span>
                            </div>
                            <div class="summary-row">
                                <span style="font-size:13px;color:var(--border-light);">Ongkos Kirim</span>
                                <span
                                    style="font-size:14px;font-weight:600;color:<?= $ongkir == 0 ? 'var(--success-badge)' : 'var(--bg-surface)' ?>;">
                                    <?= $ongkir == 0 ? 'GRATIS' : formatRupiah($ongkir) ?>
                                </span>
                            </div>
                            <div class="summary-row"
                                style="border-top:1px solid var(--border-light);margin-top:8px;padding-top:16px;">
                                <span style="font-weight:800;">Total Bayar</span>
                                <span
                                    style="color:var(--bg-surface);font-size:20px;font-family:'Cormorant Garamond',serif;"><?= formatRupiah($totalBayar) ?></span>
                            </div>
                        </div>
                        <a href="checkout.php" class="btn-promo w-100 text-center mt-4 d-block" style="border-radius:12px;">
                            <i class="fas fa-credit-card me-2"></i>Lanjut ke Checkout
                        </a>
                        <div class="d-flex gap-3 justify-content-center mt-3">
                            <small style="color:var(--border-light);font-size:11px;"><i
                                    class="fas fa-shield-alt me-1"></i>Transaksi Aman</small>
                            <small style="color:var(--border-light);font-size:11px;"><i class="fas fa-lock me-1"></i>SSL
                                Enkripsi</small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>