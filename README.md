# Travelbag — Website Koper Premium
## Panduan Instalasi di Laragon

---

## 📋 PERSYARATAN
- Laragon (versi 5.x atau terbaru)
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.4+

---

## 🚀 LANGKAH INSTALASI

### 1. Salin File ke Laragon
```
Copy seluruh folder `koper_website` ke:
C:\laragon\www\koper_website\
```

### 2. Setup Database
**Cara 1 – phpMyAdmin:**
1. Buka http://localhost/phpmyadmin
2. Klik **"New"** → buat database `koper_db`
3. Pilih database `koper_db` → klik tab **"Import"**
4. Upload file `database/koper_db.sql`
5. Klik **"Go"** untuk import

**Cara 2 – Laragon Terminal:**
```bash
mysql -u root -e "CREATE DATABASE koper_db;"
mysql -u root koper_db < database/koper_db.sql
```

### 3. Konfigurasi Database (jika perlu)
Edit file `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'koper_db');
define('DB_USER', 'root');    // default Laragon
define('DB_PASS', '');        // default Laragon kosong
```

### 4. Akses Website
Buka browser: **http://localhost/koper_website**

---

## 📁 STRUKTUR FILE

```
koper_website/
├── index.php           ← Halaman Beranda
├── produk.php          ← Daftar Produk
├── detail.php          ← Detail Produk
├── keranjang.php       ← Keranjang Belanja
├── kontak.php          ← Halaman Kontak
├── config/
│   └── database.php    ← Konfigurasi DB
├── includes/
│   ├── navbar.php      ← Navbar
│   └── footer.php      ← Footer
├── api/
│   └── cart.php        ← API Keranjang (AJAX)
├── assets/
│   ├── css/style.css   ← Stylesheet Utama
│   └── js/main.js      ← JavaScript Utama
└── database/
    └── koper_db.sql    ← Database SQL
```

---

## 🎨 FITUR WEBSITE

### Halaman Utama (index.php)
- Hero section animasi dengan floating badge
- Section keunggulan (gratis ongkir, garansi, dll)
- Kategori produk dengan hover effects
- Produk unggulan dengan overlay
- Banner promo dengan countdown timer
- Testimoni pelanggan
- Newsletter signup

### Produk (produk.php)
- Filter berdasarkan kategori
- Pencarian produk
- Sort (terlaris, terbaru, harga, rating)
- Pagination
- Card produk dengan badge dan hover effects

### Detail Produk (detail.php)
- Gambar produk animasi
- Spesifikasi lengkap
- Pilihan warna
- Qty control
- Tambah ke keranjang (AJAX)
- Form ulasan & rating
- Produk terkait

### Keranjang (keranjang.php)
- Update qty AJAX
- Hapus produk AJAX
- Kalkulasi ongkir otomatis
- Ringkasan pesanan

### Kontak (kontak.php)
- Form kontak tersimpan ke database
- Info kontak lengkap

---

## 🎨 TEMA WARNA

| Warna | Hex | Penggunaan |
|-------|-----|-----------|
| Navy 900 | #0a1628 | Background utama gelap |
| Navy 700 | #122347 | Gradient |
| Royal Blue | #1e40af | Aksen utama |
| Gold | #c9a84c | Aksen premium |
| Off White | #f0f4ff | Background section |

---

## ⚙️ KONFIGURASI TAMBAHAN

### Upload Gambar Produk
Tambahkan gambar ke folder `assets/images/produk/` dan update kolom `gambar` di tabel `produk`.

### Aktifkan Checkout
Buat file `checkout.php` dengan form pengiriman dan pembayaran.

---

## 🐛 TROUBLESHOOTING

**Error koneksi DB:**
→ Pastikan Laragon berjalan dan MySQL aktif
→ Cek DB_USER dan DB_PASS di config/database.php

**Halaman blank:**
→ Aktifkan error reporting: tambah `error_reporting(E_ALL);` di index.php
→ Cek Laragon log: klik kanan tray icon → Logs

**Session tidak bekerja:**
→ Pastikan PHP session sudah aktif di php.ini
→ Laragon: klik kanan → PHP → php.ini → cek session.save_path

---

*Dibuat dengan ❤️ menggunakan HTML, PHP, JavaScript, CSS, Bootstrap 5 & MySQL*
