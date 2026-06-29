<?php
require_once 'config/database.php';
$db = getDB();

$stmtFeatured = $db->query("SELECT p.*, k.nama as kategori_nama FROM produk p JOIN kategori k ON p.kategori_id = k.id WHERE p.featured = 1 AND p.aktif = 1 LIMIT 6");
$produkFeatured = $stmtFeatured->fetchAll();

$stmtKat = $db->query("SELECT k.*, COUNT(p.id) as jml_produk FROM kategori k LEFT JOIN produk p ON k.id = p.kategori_id AND p.aktif = 1 GROUP BY k.id LIMIT 5");
$kategoris = $stmtKat->fetchAll();

$stmtUlasan = $db->query("SELECT u.*, p.nama as produk_nama FROM ulasan u JOIN produk p ON u.produk_id = p.id ORDER BY u.id DESC LIMIT 3");
$ulasans = $stmtUlasan->fetchAll();

$totalProduk = $db->query("SELECT COUNT(*) FROM produk WHERE aktif=1")->fetchColumn();
$totalTerjual = $db->query("SELECT SUM(terjual) FROM produk")->fetchColumn();

function getImgSrc($gambar)
{
    $png = preg_replace('/\.(jpg|jpeg|png)$/i', '.png', $gambar);
    return 'assets/images/produk/' . $png;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bag Travel</title>
    <!-- <link rel="icon" type="image/png" href="#"> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet"> -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css?=103" rel="stylesheet">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- HERO -->
    <section class="hero-section" id="home" style="background:var(--bg-grad);>
        <div class="hero-bg-pattern"></div>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <div class="hero-badge mb-2">
                        <i class="fas fa-crown me-2"></i> Premium Luggage Collection 2026
                    </div>
                    <h1 class="hero-title">
                        Jelajahi Dunia<br>
                        <span class="hero-title-accent">Dengan Gaya</span>
                    </h1>
                    <p class="hero-subtitle">Koper premium berkualitas tinggi untuk setiap petualangan Anda. Dirancang
                        dengan material terbaik, ringan namun kokoh.</p>
                    <div class="hero-stats d-flex gap-4 mb-4">
                        <div class="stat-item">
                            <div class="stat-number"><?= number_format($totalProduk) ?>+</div>
                            <div class="stat-label">Produk</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?= number_format($totalTerjual) ?>+</div>
                            <div class="stat-label">Terjual</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Kepuasan</div>
                        </div>
                    </div>
                    <div class="hero-buttons d-flex gap-3 flex-wrap">
                        <a href="produk.php" class="btn-primary-custom" style="color:var(--secondary);"><i
                                class="fas fa-shopping-bag me-2"></i>Belanja
                            Sekarang</a>
                        <a href="#produk-featured" class="btn-outline-custom"><i class="fas fa-play me-2"></i>Lihat
                            Koleksi</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="hero-image-container" style="position:relative;display:inline-block;">
                        <div class="hero-image-glow"></div>
                        <img src="assets/images/produk/koper4.png" alt="Koper LuxeTravel Premium" class="hero-main-img"
                            style="width:380px;max-width:100%;filter:drop-shadow(0 20px 50px var(--shadow-dark));animation:floatCard 4s ease-in-out infinite;">
                        <div class="hero-floating-badge badge-1"><i class="fas fa-shield-alt me-1"></i> TSA Lock</div>
                        <div class="hero-floating-badge badge-2"><i class="fas fa-feather-alt me-1"></i> Ultra Ringan
                        </div>
                        <div class="hero-floating-badge badge-3"><i class="fas fa-star me-1"></i> 5.0 Rating</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <div class="scroll-mouse">
                <div class="scroll-wheel"></div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row g-4">
                <?php
                $features = [
                    ['fas fa-shipping-fast', 'Gratis Ongkir', 'Gratis ongkos kirim untuk pembelian di atas Rp 500.000 ke seluruh Indonesia'],
                    ['fas fa-shield-alt', 'Garansi Resmi', 'Garansi produk resmi hingga 2 tahun untuk setiap pembelian koper premium'],
                    ['fas fa-undo-alt', 'Mudah Return', '30 hari pengembalian produk jika terdapat cacat atau ketidaksesuaian dengan produk'],
                    ['fas fa-lock', 'Bayar Aman', 'Transaksi aman dengan enkripsi SSL 256-bit dan berbagai metode pembayaran'],
                ];
                foreach ($features as $i => $f): ?>
                    <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <div class="feature-card text-center">
                            <div class="feature-icon"><i class="<?= $f[0] ?>"></i></div>
                            <h6 class="feature-title"><?= $f[1] ?></h6>
                            <p class="feature-desc"><?= $f[2] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- KATEGORI -->
    <section class="kategori-section py-5" id="kategori">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <div class="section-tag">KATEGORI</div>
                <h2 class="section-title">Temukan Koper <span>Impian Anda</span></h2>
            </div>
            <div class="row g-4">
                <?php foreach ($kategoris as $i => $kat): ?>
                    <div class="col-lg-<?= $i === 0 ? '4' : '2' ?> col-md-4 col-6" data-aos="zoom-in"
                        data-aos-delay="<?= $i * 80 ?>">
                        <a href="produk.php?kategori=<?= $kat['slug'] ?>"
                            class="kategori-card <?= $i === 0 ? 'kategori-featured' : '' ?>">
                            <div class="kategori-icon"><i class="<?= $kat['ikon'] ?>"></i></div>
                            <div class="kategori-info">
                                <h6><?= $kat['nama'] ?></h6><span><?= $kat['jml_produk'] ?> Produk</span>
                            </div>
                            <!-- <div class="kategori-arrow"><i class="fas fa-arrow-right"></i></div> -->
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- PRODUK UNGGULAN -->
    <section class="produk-section py-5 bg-light-blue" id="produk-featured">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
                <div>
                    <div class="section-tag">UNGGULAN</div>
                    <h2 class="section-title mb-0">Produk <span>Terlaris</span></h2>
                </div>
                <a href="produk.php" class="btn-link-custom">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <?php foreach ($produkFeatured as $i => $p): ?>
                    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                        <div class="produk-card">
                            <!-- <?php if ($p['badge']): ?>
                                <div class="produk-badge badge-<?= strtolower($p['badge']) ?>"><?= $p['badge'] ?></div>
                            <?php endif; ?> -->
                            <div class="produk-image">
                                <img src="<?= getImgSrc($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>"
                                    class="produk-img-real">
                                <div class="produk-overlay">
                                    <a href="detail.php?id=<?= $p['id'] ?>" class="btn-detail"><i
                                            class="fas fa-eye me-1"></i>Detail</a>
                                    <!-- <button class="btn-cart"
                                        onclick="addToCart(<?= $p['id'] ?>, '<?= addslashes($p['nama']) ?>', <?= $p['harga'] ?>)"><i
                                            class="fas fa-cart-plus"></i></button> -->
                                </div>
                            </div>
                            <div class="produk-info">
                                <div class="produk-kategori"><?= $p['kategori_nama'] ?></div>
                                <h5 class="produk-nama"><a href="detail.php?id=<?= $p['id'] ?>"><?= $p['nama'] ?></a></h5>
                                <div class="produk-rating">
                                    <div class="stars text-warning"><?= renderBintang($p['rating']) ?></div>
                                    <span class="rating-text"><?= $p['rating'] ?> </span>
                                </div>
                                <div class="produk-harga">
                                    <span class="harga-utama"><?= formatRupiah($p['harga']) ?></span>
                                    <?php if ($p['harga_coret']): ?><span
                                            class="harga-coret"><?= formatRupiah($p['harga_coret']) ?></span><?php endif; ?>
                                </div>
                                <?php if ($p['harga_coret']):
                                    $d = round((($p['harga_coret'] - $p['harga']) / $p['harga_coret']) * 100); ?>
                                    <div class="produk-diskon">Hemat <?= $d ?>%</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SEMUA PRODUK PREVIEW -->
    <section class="py-5" style="background:var(--bg-surface);">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <div class="section-tag">KOLEKSI LENGKAP</div>
                <h2 class="section-title">Semua <span>Koleksi Kami</span></h2>
            </div>
            <?php $allProds = $db->query("SELECT p.*, k.nama as kategori_nama FROM produk p JOIN kategori k ON p.kategori_id = k.id WHERE p.aktif=1 ORDER BY p.terjual DESC")->fetchAll(); ?>
            <div class="row g-4">
                <?php foreach ($allProds as $i => $p): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                        <div class="produk-card">
                            <!-- <?php if ($p['badge']): ?>
                        <div class="produk-badge badge-<?= strtolower($p['badge']) ?>"><?= $p['badge'] ?></div>
                        <?php endif; ?> -->
                            <div class="produk-image">
                                <img src="<?= getImgSrc($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>"
                                    class="produk-img-real">
                                <div class="produk-overlay">
                                    <a href="detail.php?id=<?= $p['id'] ?>" class="btn-detail"><i
                                            class="fas fa-eye me-1"></i>Detail</a>
                                    <!-- <button class="btn-cart"
                                        onclick="addToCart(<?= $p['id'] ?>, '<?= addslashes($p['nama']) ?>', <?= $p['harga'] ?>)"><i
                                            class="fas fa-cart-plus"></i></button> -->
                                </div>
                            </div>
                            <div class="produk-info">
                                <div class="produk-kategori"><?= $p['kategori_nama'] ?></div>
                                <h5 class="produk-nama"><a href="detail.php?id=<?= $p['id'] ?>"><?= $p['nama'] ?></a></h5>
                                <div class="produk-rating">
                                    <div class="stars text-warning"><?= renderBintang($p['rating']) ?></div>
                                    <span class="rating-text"><?= $p['rating'] ?></span>
                                </div>
                                <div class="produk-harga">
                                    <span class="harga-utama"><?= formatRupiah($p['harga']) ?></span>
                                    <?php if ($p['harga_coret']): ?><span
                                            class="harga-coret"><?= formatRupiah($p['harga_coret']) ?></span><?php endif; ?>
                                </div>
                                <?php if ($p['harga_coret']):
                                    $d = round((($p['harga_coret'] - $p['harga']) / $p['harga_coret']) * 100); ?>
                                    <div class="produk-diskon">Hemat <?= $d ?>%</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- PROMO BANNER -->
    <!-- <section class="promo-banner py-5">
        <div class="container">
            <div class="promo-card" data-aos="zoom-in">
                <div class="promo-bg-decoration"></div>
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="promo-tag">PENAWARAN TERBATAS</div>
                        <h2 class="promo-title">Diskon Hingga <span>40%</span> untuk Koper Set!</h2>
                        <p class="promo-subtitle">Beli paket set 3 koper, hemat jutaan rupiah. Tersedia dalam berbagai
                            warna pilihan.</p>
                        <div class="promo-countdown">
                            <div class="countdown-item"><span id="cnt-jam">00</span><small>Jam</small></div>
                            <div class="countdown-sep">:</div>
                            <div class="countdown-item"><span id="cnt-mnt">00</span><small>Menit</small></div>
                            <div class="countdown-sep">:</div>
                            <div class="countdown-item"><span id="cnt-dtk">00</span><small>Detik</small></div>
                        </div>
                    </div>
                    <div class="col-md-5 text-center mt-3 mt-md-0">
                        <img src="assets/images/produk/set1.svg" alt="Koper Set Promo"
                            style="width:240px;filter:drop-shadow(0 10px 30px var(--shadow-dark));animation:floatCard 3s ease-in-out infinite;">
                        <br>
                        <a href="produk.php?kategori=set" class="btn-promo mt-3 d-inline-block">Klaim Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- TESTIMONI -->
    <section class="testimoni-section py-5" id="testimoni">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <div class="section-tag">TESTIMONI</div>
                <h2 class="section-title">Kata Mereka <span>Tentang Kami</span></h2>
            </div>
            <div class="row g-4">
                <?php foreach ($ulasans as $i => $u): ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <div class="testimoni-card">
                            <div class="testimoni-quote"><i class="fas fa-quote-left"></i></div>
                            <p class="testimoni-text"><?= $u['komentar'] ?></p>
                            <div class="testimoni-rating text-warning mb-2"><?= renderBintang($u['rating']) ?></div>
                            <div class="testimoni-author d-flex align-items-center gap-3">
                                <div class="author-avatar"><?= strtoupper(substr($u['nama'], 0, 1)) ?></div>
                                <div>
                                    <div class="author-name"><?= $u['nama'] ?></div>
                                    <div class="author-product"><?= $u['produk_nama'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER -->
    <!-- <section class="newsletter-section py-5">
        <div class="container">
            <div class="newsletter-card text-center" data-aos="zoom-in">
                <i class="fas fa-envelope-open-text newsletter-icon mb-3"></i>
                <h3 class="newsletter-title">Dapatkan Promo Eksklusif</h3>
                <p class="newsletter-sub">Daftarkan email Anda dan dapatkan diskon 10% untuk pembelian pertama</p>
                <form class="newsletter-form d-flex gap-2 justify-content-center flex-wrap"
                    onsubmit="submitNewsletter(event)">
                    <input type="email" class="newsletter-input" placeholder="Masukkan email Anda..." required>
                    <button type="submit" class="btn-newsletter"><i class="fas fa-paper-plane me-2"></i>Daftar
                        Sekarang</button>
                </form>
            </div>
        </div>
    </section> -->

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script> -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>AOS.init({ once: true, offset: 80 }); startCountdown(8, 45, 30);</script>
</body>

</html>