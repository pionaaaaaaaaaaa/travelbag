<footer class="footer-section">
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">
                <!-- Brand -->
                <div class="col-lg-4">
                    <div class="footer-brand d-flex flex-column align-items-start">
                       <img src="assets/images/logo.png" alt="Bag Travel" class="footer-logo mb-2">
                        <span class="footer-brand-name">Travel Bag</span>
                    </div>
                    <p class="footer-desc mt-3">
                        Toko koper premium terpercaya di Indonesia sejak 2015.
                        Kami menyediakan koper berkualitas tinggi untuk setiap perjalanan Anda.
                    </p>
                    <div class="footer-social d-flex gap-3 mt-4">
                        <a href="https://www.instagram.com/" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Menu -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="produk.php">Semua Produk</a></li>
                        <li><a href="tentang.php">Tentang Kami</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                        <!-- <li><a href="blog.php">Blog</a></li> -->
                    </ul>
                </div>

                <!-- Kategori -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-heading">Kategori</h6>
                    <ul class="footer-links">
                        <li><a href="produk.php?kategori=kabin">Koper Kabin</a></li>
                        <li><a href="produk.php?kategori=medium">Koper Medium</a></li>
                        <li><a href="produk.php?kategori=besar">Koper Besar</a></li>
                        <li><a href="produk.php?kategori=set">Koper Set</a></li>
                        <li><a href="produk.php?kategori=aksesoris">Aksesoris</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-heading">Hubungi Kami</h6>
                    <ul class="footer-contact-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. rumah</span>
                        </li>
                        <!-- <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+62 878 1183 8864</span>
                        </li>
                        <li>
                            <i class="fab fa-whatsapp"></i>
                            <span>+62 878 1183 8864</span>
                        </li> -->
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>hello@BagTravel.id</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Senin - Sabtu: 09.00 - 18.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="footer-copy mb-0">
                        &copy; <?= date('Y') ?> <strong>Cikumi</strong>. Hak Cipta Dilindungi.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <!-- <div
                        class="footer-payment d-flex gap-2 justify-content-md-end justify-content-start flex-wrap mt-2 mt-md-0">
                        <span class="payment-badge">BCA</span>
                        <span class="payment-badge">Mandiri</span>
                        <span class="payment-badge">GoPay</span>
                        <span class="payment-badge">OVO</span>
                        <span class="payment-badge">Dana</span>
                        <span class="payment-badge">COD</span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<button class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast align-items-center border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <i class="fas fa-check-circle me-2 text-success"></i>
                Produk berhasil ditambahkan ke keranjang!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>