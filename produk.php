<?php
require_once 'config/database.php';
$db = getDB();

// Filter & Search
$kategoriSlug = isset($_GET['kategori']) ? sanitize($_GET['kategori']) : '';
$cari = isset($_GET['cari']) ? sanitize($_GET['cari']) : '';
$sort = isset($_GET['sort']) ? sanitize($_GET['sort']) : 'terlaris';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 9;
$offset = ($page - 1) * $perPage;

// Build Query
$where = ['p.aktif = 1'];
$params = [];

if ($kategoriSlug) {
    $where[] = 'k.slug = ?';
    $params[] = $kategoriSlug;
}

if ($cari) {
    $where[] = '(p.nama LIKE ? OR p.deskripsi LIKE ?)';
    $params[] = "%$cari%";
    $params[] = "%$cari%";
}

$whereStr = 'WHERE ' . implode(' AND ', $where);

$orderBy = match ($sort) {
    'harga_asc' => 'p.harga ASC',
    'harga_desc' => 'p.harga DESC',
    'terbaru' => 'p.created_at DESC',
    'rating' => 'p.rating DESC',
    default => 'p.terjual DESC'
};

// Count
$stmtCount = $db->prepare("SELECT COUNT(*) FROM produk p JOIN kategori k ON p.kategori_id = k.id $whereStr");
$stmtCount->execute($params);
$totalProduk = $stmtCount->fetchColumn();
$totalPage = ceil($totalProduk / $perPage);

// Produk
$sql = "SELECT p.*, k.nama as kategori_nama, k.slug as kategori_slug FROM produk p JOIN kategori k ON p.kategori_id = k.id $whereStr ORDER BY $orderBy LIMIT $perPage OFFSET $offset";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$produks = $stmt->fetchAll();

// Kategori sidebar
$stmtKat = $db->query("SELECT k.*, COUNT(p.id) as jml FROM kategori k LEFT JOIN produk p ON k.id = p.kategori_id AND p.aktif = 1 GROUP BY k.id");
$kategoris = $stmtKat->fetchAll();

// Harga range
$hargaRange = $db->query("SELECT MIN(harga) as min_h, MAX(harga) as max_h FROM produk WHERE aktif=1")->fetch();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Koper — LuxeTravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet"> -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Page Header -->
    <div class="page-header" style="background:var(--secondary)">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Produk <?= $kategoriSlug ? '/ ' . ucfirst($kategoriSlug) : '' ?>
                    </li>
                </ol>
            </nav>
            <h1 class="page-header-title mt-2">
                <?= $cari ? "Hasil: \"$cari\"" : ($kategoriSlug ? "Koper " . ucwords(str_replace('-', ' ', $kategoriSlug)) : 'Semua Produk') ?>
            </h1>
            <p class="page-header-sub"><?= $totalProduk ?> produk ditemukan</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">

            <!-- Sidebar Filter -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <!-- Search -->
                    <div class="filter-title"><i class="fas fa-search me-2"></i>Cari Produk</div>
                    <form action="produk.php" method="GET" class="mb-4">
                        <?php if ($kategoriSlug): ?>
                            <input type="hidden" name="kategori" value="<?= $kategoriSlug ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <input type="text" name="cari" class="form-control" placeholder="Nama koper..."
                                value="<?= htmlspecialchars($cari) ?>"
                                style="font-size:13px; border-radius: 8px 0 0 8px;">
                            <button type="submit" class="btn"
                                style="background: var(--primary-hover); color: white; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Kategori -->
                    <div class="filter-title"><i class="fas fa-list me-2"></i>Kategori</div>
                    <div class="mb-4">
                        <a href="produk.php" class="filter-item <?= !$kategoriSlug ? 'active' : '' ?>" data-slug="">
                            <i class="fas fa-th me-2"></i> Semua Kategori
                            <span class="filter-count"><?= $totalProduk ?></span>
                        </a>
                        <?php foreach ($kategoris as $kat): ?>
                            <a href="produk.php?kategori=<?= $kat['slug'] ?>"
                                class="filter-item <?= $kategoriSlug === $kat['slug'] ? 'active' : '' ?>"
                                data-slug="<?= $kat['slug'] ?>">
                                <i class="<?= $kat['ikon'] ?> me-2"></i> <?= $kat['nama'] ?>
                                <span class="filter-count"><?= $kat['jml'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Urutkan -->
                    <div class="filter-title"><i class="fas fa-sort me-2"></i>Urutkan</div>
                    <div>
                        <?php $sorts = ['terlaris' => 'Terlaris', 'terbaru' => 'Terbaru', 'harga_asc' => 'Harga Terendah', 'harga_desc' => 'Harga Tertinggi', 'rating' => 'Rating Terbaik']; ?>
                        <?php foreach ($sorts as $key => $label): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['sort' => $key])) ?>"
                                class="filter-item <?= $sort === $key ? 'active' : '' ?>">
                                <?= $label ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <?php if (empty($produks)): ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-search"></i></div>
                        <h4>Produk Tidak Ditemukan</h4>
                        <p class="text-muted">Coba kata kunci atau kategori lain</p>
                        <a href="produk.php" class="btn-primary-custom mt-3">Lihat Semua Produk</a>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($produks as $i => $p): ?>
                            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                                <div class="produk-card">
                                    <!-- <?php if ($p['badge']): ?>
                                        <div class="produk-badge badge-<?= strtolower($p['badge']) ?>"><?= $p['badge'] ?></div>
                                    <?php endif; ?> -->
                                    <div class="produk-image">
                                        <img src="<?= 'assets/images/produk/' . preg_replace('/\.(jpg|jpeg|png)$/i', '.png', $p['gambar']) ?>"
                                            alt="<?= htmlspecialchars($p['nama']) ?>" class="produk-img-real">
                                        <div class="produk-overlay">
                                            <a href="detail.php?id=<?= $p['id'] ?>" class="btn-detail">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            <!-- <button class="btn-cart"
                                                onclick="addToCart(<?= $p['id'] ?>, '<?= addslashes($p['nama']) ?>', <?= $p['harga'] ?>)">
                                                <i class="fas fa-cart-plus"></i>
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="produk-info">
                                        <div class="produk-kategori"><?= $p['kategori_nama'] ?></div>
                                        <h5 class="produk-nama">
                                            <a href="detail.php?id=<?= $p['id'] ?>"><?= $p['nama'] ?></a>
                                        </h5>
                                        <div class="produk-rating">
                                            <div class="stars text-warning"><?= renderBintang($p['rating']) ?></div>
                                            <span class="rating-text"><?= $p['rating'] ?></span>
                                        </div>
                                        <div class="produk-harga">
                                            <span class="harga-utama"><?= formatRupiah($p['harga']) ?></span>
                                            <?php if ($p['harga_coret']): ?>
                                                <span class="harga-coret"><?= formatRupiah($p['harga_coret']) ?></span>
                                            <?php endif; ?>
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

                    <!-- Pagination -->
                    <?php if ($totalPage > 1): ?>
                        <nav class="mt-5 d-flex justify-content-center">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                                            style="background:<?= $i == $page ? 'var(--primary-hover)' : 'var(--bg-surface)' ?>; border-color:<?= $i == $page ? 'var(--primary-hover)' : 'var(--secondary)' ?>; color:<?= $i == $page ? 'var(--bg-surface)' : 'var(--primary)' ?>;"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script> -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>AOS.init({ once: true, offset: 80 });</script>
</body>

</html>