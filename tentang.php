<?php
require_once 'config/auth.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami — Travel Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* ===== TENTANG PAGE STYLES ===== */

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary) 100%);
            padding: 140px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-header-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 5vw, 52px);
            font-weight: 700;
            color: var(--bg-surface);
        }

        .page-header-sub {
            color: var(--border-light);
            font-size: 15px;
            margin-top: 8px;
        }

        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: var(--bg-surface);
            text-decoration: none;
            font-size: 13px;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: var(--border-light);
            font-size: 13px;
        }

        .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
            color: var(--border-light);
        }

        /* Story Section */
        .story-section {
            padding: 90px 0;
            background: var(--bg-main);
        }

        .story-image-wrap {
            position: relative;
            border-radius: var(--radius-xl);
            overflow: hidden;
        }

        .story-image-wrap img {
            width: 100%;
            height: 480px;
            object-fit: contain;
            background: var(--secondary);
            border-radius: var(--radius-xl);
        }

        .story-badge-float {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background: var(--primary);
            color: white;
            border-radius: var(--radius-lg);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-lg);
        }

        .story-badge-float .badge-icon {
            width: 52px;
            height: 52px;
            background: var(--bg-surface);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .story-badge-float .badge-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
        }

        .story-badge-float .badge-text {
            font-size: 12px;
            color: var(--border-light);
            margin-top: 2px;
        }

        .story-content h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 4vw, 44px);
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .story-content h2 span {
            color: var(--primary);
        }

        .story-content p {
            color: var(--text-main);
            font-size: 15px;
            line-height: 1.85;
        }

        .label-above {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 12px;
            display: block;
        }

        /* Stats Bar */
        .stats-bar {
            background: linear-gradient(135deg, var(--primary), var(--primary));
            padding: 60px 0;
        }

        .stat-box {
            text-align: center;
            color: white;
            padding: 20px;
            position: relative;
        }

        .stat-box:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: var(--border-light);
        }

        .stat-box .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            font-weight: 700;
            color: var(--bg-surface);
            line-height: 1;
        }

        .stat-box .stat-unit {
            font-size: 24px;
        }

        .stat-box .stat-lbl {
            font-size: 13px;
            color: var(--border-light);
            margin-top: 6px;
            letter-spacing: 0.5px;
        }

        /* Values Section */
        .values-section {
            padding: 90px 0;
            background: var(--bg-surface);
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 700;
            color: var(--primary);
        }

        .section-title span {
            color: var(--primary);
        }

        .section-sub {
            color: var(--text-muted);
            font-size: 15px;
            max-width: 520px;
            margin: 0 auto;
        }

        .value-card {
            background: var(--bg-main);
            border-radius: var(--radius-lg);
            padding: 36px 30px;
            height: 100%;
            transition: var(--transition);
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .value-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--bg-surface), var(--bg-surface));
            transform: scaleX(0);
            transition: var(--transition);
            transform-origin: left;
        }

        .value-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: var(--bg-surface);
        }

        .value-card:hover::before {
            transform: scaleX(1);
        }

        .value-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--primary), var(--primary));
            color: var(--bg-surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .value-card h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .value-card p {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }

        /* Team Section */
        .team-section {
            padding: 90px 0;
            background: var(--secondary);
        }

        .team-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .team-img-wrap {
            height: 230px;
            background: linear-gradient(135deg, var(--primary), var(--primary));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .team-img-wrap .team-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: var(--bg-surface);
            border: 3px solid var(--shadow-medium);
        }

        .team-img-wrap .team-initials {
            font-family: 'Cormorant Garamond', serif;
            font-size: 44px;
            font-weight: 700;
            color: var(--bg-surface);
        }

        .team-card-body {
            padding: 24px;
            text-align: center;
        }

        .team-card-body h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .team-card-body .team-role {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .team-card-body p {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.65;
            margin: 0;
        }

        /* Timeline Section */
        .timeline-section {
            padding: 90px 0;
            background: var(--bg-main);
        }

        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 44px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -35px;
            top: 6px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid var(--primary);
            box-shadow: 0 0 0 3px var(--primary);
        }

        .timeline-year {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .timeline-item h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .timeline-item p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--primary));
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: var(--shadow-light);
            top: -100px;
            right: -100px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: var(--shadow-light);
            bottom: -80px;
            left: -80px;
        }

        .cta-section h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(30px, 4vw, 44px);
            font-weight: 700;
            color: var(--bg-surface);
            margin-bottom: 16px;
        }

        .cta-section h2 span {
            color: var(--bg-surface);
        }

        .cta-section p {
            color: var(--border-light);
            font-size: 15px;
            max-width: 500px;
            margin: 0 auto 36px;
        }

        /* Guarantee strip */
        .guarantee-strip {
            background: var(--secondary);
            padding: 36px 0;
            border-top: 1px solid var(--bg-surface);
            border-bottom: 1px solid var(--bg-surface);
        }

        .guarantee-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 0 20px;
        }

        .guarantee-item i {
            font-size: 28px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .guarantee-item strong {
            display: block;
            font-size: 14px;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .guarantee-item span {
            font-size: 12.5px;
            color: var(--text-muted);
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Page Header -->
    <div class="page-header" style="background:var(--secondary)">
        <div class="container">
            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Tentang Kami</li>
                </ol>
            </nav>
            <h1 class="page-header-title mt-2">Tentang Kami</h1>
            <p class="page-header-sub">Perjalanan kami menemani jutaan petualangan Anda sejak 2015</p>
        </div>
    </div>

    <!-- Story Section -->
    <section class="story-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="story-image-wrap">
                        <img src="assets/images/produk/koper_set.png" alt="Koleksi Koper Travel Bag">
                        <div class="story-badge-float">
                            <div class="badge-icon"><i class="fas fa-award"></i></div>
                            <div>
                                <div class="badge-num">10+</div>
                                <div class="badge-text">Tahun Pengalaman</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left">
                    <div class="story-content ps-lg-4">
                        <span class="label-above">Kisah Kami</span>
                        <h2>Berawal dari Satu <span>Koper & Satu Mimpi</span></h2>
                        <p class="mt-4">
                            Travel Bag lahir dari sebuah mimpi sederhana: membantu masyarakat Indonesia menemukan koper premium berkualitas internasional dengan harga yang paling masuk akal dan sesuai kebutuhan. Kami percaya bahwa setiap perjalanan yang nyaman layak dimulai dengan pemilihan perlengkapan terbaik tanpa salah pilih.
                        </p>
                        <p class="mt-3">
                            Dimulai dari langkah awal kami di situs belanja online, kami kini telah mengkurasi pilihan terbaik dan memandu lebih dari 50.000 pelancong di seluruh Indonesia. Setiap koper yang kami rekomendasikan telah melewati seleksi dan penilaian kualitas yang ketat, mulai dari ketahanan material, kekuatan engsel, kelancaran roda, hingga sistem penguncian TSA yang telah bersertifikat internasional.
                        </p>
                        <p class="mt-3">
                            Kami bukan sekadar mengulas koper — kami membagikan kepercayaan, kenyamanan, dan ketenangan pikiran untuk setiap perjalanan Anda. Karena kami tahu, petualangan terbaik dimulai ketika Anda berhasil memilih koper yang tepat tanpa rasa khawatir.
                        </p>

                        <div class="row g-3 mt-4">
                            <div class="col-6">
                                <div style="padding:20px;background:var(--secondary);border-radius:var(--radius-md);border-left:3px solid var(--bg-surface);">
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:var(--primary);">50.000+</div>
                                    <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">Pelanggan Puas</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div style="padding:20px;background:var(--secondary);border-radius:var(--radius-md);border-left:3px solid var(--bg-surface);">
                                    <div style="font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:var(--primary);">98%</div>
                                    <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">Tingkat Kepuasan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="stats-bar">
        <div class="container">
            <div class="row g-0">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-box">
                        <div class="stat-num">10<span class="stat-unit">+</span></div>
                        <div class="stat-lbl">Tahun Berpengalaman</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-box">
                        <div class="stat-num">50K<span class="stat-unit">+</span></div>
                        <div class="stat-lbl">Pelanggan Setia</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-box">
                        <div class="stat-num">34<span class="stat-unit">+</span></div>
                        <div class="stat-lbl">Varian Produk</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-box">
                        <div class="stat-num">4.9<span class="stat-unit">★</span></div>
                        <div class="stat-lbl">Rating Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section" style="background:var(--secondary)">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="label-above">Nilai Kami</span>
                <h2 class="section-title">Mengapa Memilih <span>Travel Bag?</span></h2>
                <p class="section-sub mt-3">Kami berkomitmen memberikan yang terbaik di setiap aspek — dari produk hingga pelayanan.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-gem"></i></div>
                        <h5>Kualitas Premium</h5>
                        <p>Setiap produk melewati Quality Control ketat. Kami hanya menjual koper dengan material terbaik yang tahan banting dan tahan lama.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-shield-alt"></i></div>
                        <h5>Garansi Resmi</h5>
                        <p>Semua produk bergaransi resmi 6 bulan hingga 2 tahun. Kami siap mengganti atau memperbaiki jika ada cacat produksi.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-truck-fast"></i></div>
                        <h5>Pengiriman Cepat</h5>
                        <p>Pengiriman ke seluruh Indonesia. Pesanan diproses dalam 24 jam dan dikirim dengan kemasan aman agar koper tiba dalam kondisi sempurna.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-headset"></i></div>
                        <h5>CS Responsif</h5>
                        <p>Tim customer service kami siap membantu Senin–Sabtu, 09.00–18.00 WIB via WhatsApp, email, maupun formulir kontak.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-tags"></i></div>
                        <h5>Harga Kompetitif</h5>
                        <p>Kualitas premium tidak harus mahal. Kami langsung bermitra dengan produsen pilihan agar harga tetap bersahabat tanpa mengorbankan mutu.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-recycle"></i></div>
                        <h5>Ramah Lingkungan</h5>
                        <p>Packaging kami menggunakan bahan daur ulang dan minim plastik. Setiap pembelian berkontribusi pada program penanaman pohon bersama kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guarantee Strip -->
    <div class="guarantee-strip">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-6 col-md-3" data-aos="fade-up">
                    <div class="guarantee-item">
                        <i class="fas fa-lock"></i>
                        <div>
                            <strong>TSA Lock Certified</strong>
                            <span>Aman untuk penerbangan internasional</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="guarantee-item">
                        <i class="fas fa-undo-alt"></i>
                        <div>
                            <strong>Garansi Uang Kembali</strong>
                            <span>Jika tidak sesuai dalam 7 hari</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="guarantee-item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>100% Produk Asli</strong>
                            <span>Bersertifikat & bergaransi resmi</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="guarantee-item">
                        <i class="fas fa-shipping-fast"></i>
                        <div>
                            <strong>Gratis Ongkir</strong>
                            <span>Untuk pembelian di atas Rp500.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <section class="timeline-section">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-4" data-aos="fade-right">
                    <span class="label-above">Perjalanan Kami</span>
                    <h2 class="section-title">Dari <span>Satu Toko</span><br>Menuju Indonesia</h2>
                    <p style="color:var(--text-muted);font-size:15px;line-height:1.8;margin-top:16px;">
                        Setiap tahun adalah babak baru. Inilah tonggak perjalanan Travel Bag sejak pertama kali dibuka hingga hari ini.
                    </p>
                    <div class="mt-4">
                        <img src="assets/images/produk/koper4.png" alt="Perjalanan Travel Bag"
                            style="width:100%;max-width:320px;filter:drop-shadow(0 10px 30px var(--shadow-medium));">
                    </div>
                </div>

                <div class="col-lg-8" data-aos="fade-left">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2015</div>
                            <h5>Berdiri di Situs Belanja Online</h5>
                            <p>Travel Bag pertama kali memulai perjalanannya melalui situs belanja online. Dengan semangat besar, kami mulai hadir untuk membantu melayani dan memandu para pelanggan pertama kami.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2017</div>
                            <h5>Ekspansi Rekomendasi Secara Online</h5>
                            <p>Kami memperluas jangkauan panduan kami ke berbagai platform online lainnya, membantu para traveler di seluruh Jawa dan Bali. Antusiasme masyarakat yang mencari panduan memilih koper meningkat hingga 3x lipat dalam setahun pertama ekspansi digital ini.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2019</div>
                            <h5>Kurasi Lini Produk LuxeTravel</h5>
                            <p>Kami mulai memperkenalkan kurasi eksklusif untuk seri LuxeTravel Pro — rekomendasi koper premium dengan material Polycarbonate import yang hingga kini menjadi pilihan paling diminati sepanjang masa.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2021</div>
                            <h5>10.000 Pelanggan & Website Resmi</h5>
                            <p>Milestone 10.000 pengguna rekomendasi tercapai. Website resmi Travel Bag diluncurkan untuk memberikan pengalaman pencarian panduan dan rekomendasi koper yang lebih personal serta terpercaya.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2024</div>
                            <h5>Panduan Distribusi ke 34 Provinsi</h5>
                            <p>Rekomendasi Travel Bag kini telah menjangkau seluruh 34 provinsi di Indonesia. Lebih dari 50.000 pengguna telah mempercayakan keputusan pemilihan koper perjalanan mereka bersama kami.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-year">2026 — Kini</div>
                            <h5>Koleksi 2026 & Inovasi Berkelanjutan</h5>
                            <p>Memasuki tahun ini, kami meluncurkan daftar rekomendasi Premium Luggage 2026 dengan kurasi desain terbaru, tren material yang lebih ringan, serta analisis fitur smart lock generasi berikutnya. Perjalanan terbaik Anda baru saja dimulai dari pilihan yang tepat hari ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="label-above">Tim Kami</span>
                <h2 class="section-title">Orang-orang di Balik <span>Travel Bag</span></h2>
                <p class="section-sub mt-3">Tim berdedikasi yang memastikan setiap produk dan layanan kami memenuhi standar tertinggi.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="team-card">
                        <div class="team-img-wrap">
                            <div class="team-avatar">
                                <span class="team-initials">EV</span>
                            </div>
                        </div>
                        <div class="team-card-body">
                            <h5>Erviona Cecilia Agatha</h5>
                            <div class="team-role">Founder & CEO</div>
                            <p>Visioner di balik Travel Bag. Memimpin perusahaan dengan semangat bahwa setiap perjalanan adalah petualangan berharga.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card">
                        <div class="team-img-wrap">
                            <div class="team-avatar">
                                <span class="team-initials">AL</span>
                            </div>
                        </div>
                        <div class="team-card-body">
                            <h5>'Aliyya</h5>
                            <div class="team-role">Head of Products</div>
                            <p>Memastikan setiap koper yang masuk memenuhi standar kualitas ketat. 8 tahun pengalaman di industri perlengkapan perjalanan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="team-img-wrap">
                            <div class="team-avatar">
                                <span class="team-initials">NK</span>
                            </div>
                        </div>
                        <div class="team-card-body">
                            <h5>Nakila Khoirun Nisa</h5>
                            <div class="team-role">Customer Service Lead</div>
                            <p>Wajah ramah Travel Bag. Memimpin tim CS kami dalam memberikan pengalaman pelayanan yang hangat dan solutif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card">
                        <div class="team-img-wrap">
                            <div class="team-avatar">
                                <span class="team-initials">LR</span>
                            </div>
                        </div>
                        <div class="team-card-body">
                            <h5>Livia Rahadian Apandi</h5>
                            <div class="team-role">Logistics & Shipping</div>
                            <p>Memastikan setiap koper tiba di tangan Anda tepat waktu dan dalam kondisi sempurna, ke seluruh pelosok Indonesia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container position-relative" style="z-index:1;">
            <div data-aos="fade-up">
                <span class="label-above" style="color:var(--bg-surface);">Siap Memulai?</span>
                <h2>Temukan Koper Impian <span>Anda Sekarang</span></h2>
                <p>Dari kabin hingga koper besar — kami punya pilihan sempurna untuk setiap petualangan Anda.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="produk.php" class="btn-light-custom">
                        <i class="fas fa-shopping-bag me-2"></i>Lihat Semua Produk
                    </a>
                    <a href="kontak.php" class="btn-outline-light-custom">
                        <i class="fas fa-envelope me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>AOS.init({ once: true, duration: 700 });</script>
</body>

</html>
