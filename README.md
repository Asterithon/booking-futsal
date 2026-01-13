<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Booking Lapangan Futsal

Aplikasi **Booking Lapangan Futsal berbasis Web** yang dibangun menggunakan **Laravel 12**.  
Project ini merupakan **fondasi sistem** (foundation project) yang dirancang agar:
- Mudah dikembangkan
- Aman untuk kerja kolaboratif
- Jelas pembagian role dan alur bisnisnya

---

## 🎯 Tujuan Project

Project ini bertujuan untuk menggantikan sistem booking manual (WhatsApp / buku catatan) menjadi sistem digital yang:
- Menampilkan ketersediaan lapangan
- Menghindari double booking
- Menyediakan laporan otomatis
- Memiliki pemisahan role **Admin** dan **Customer**

⚠️ Project ini **belum bersifat final** dan memang disiapkan sebagai **fondasi pengembangan lanjutan**.

---

## 👥 Role Pengguna

### 1. Admin
- Mengelola data lapangan
- Melihat laporan booking
- Mengakses dashboard admin

### 2. Customer
- Melakukan booking lapangan
- Melihat riwayat booking
- Mengakses dashboard customer

---

## 🧱 Tech Stack

- **Laravel 12**
- PHP ≥ 8.2
- MySQL / MariaDB
- Tailwind CSS (default Laravel)
- Git & GitHub

---

## 📂 Struktur Utama Project

app/
├── Models/
│ ├── User.php
│ ├── Field.php
│ ├── Booking.php
│ └── Report.php
├── Http/
│ ├── Controllers/
│ └── Middleware/
resources/
├── views/
│ ├── dashboard.blade.php
│ ├── fields/
│ ├── bookings/
│ └── reports/
database/
├── migrations/
├── seeders/


---

## 🚀 Cara Clone & Setup Project

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/booking-futsal.git
cd booking-futsal

### 2. Install Dependency
composer install
npm install

### 3. Setup Environment
cp .env.example .env

### 4. Konfigurasi Database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_futsal
DB_USERNAME=root
DB_PASSWORD=

⚠️ Pastikan database booking_futsal sudah dibuat di MySQL.

### 5. Migrasi & Seeder
php artisan migrate --seed

### 6. Jalankan Aplikasi
npm run dev
php artisan serve

⚠️ gunakan terminal yang berbeda untuk efektifitas.

---

🔐 Akun Default (Seeder)
Admin
Email: admin@futsal.test
Password: password

Customer
Email: user@futsal.test
Password: password

---

🤝 Aturan Kolaborasi (WAJIB)

Branch utama: main (stable only)
Tidak boleh commit langsung ke main

Gunakan branch fitur:
feature/nama-fitur

Contoh Workflow
git checkout main
git pull origin main
git checkout -b feature/booking-validation

# coding

git add .
git commit -m "feat: add booking validation"
git push origin feature/booking-validation


Merge melalui Pull Request.

---

⚠️ Catatan Penting

File .env tidak boleh di-commit
Project ini menggunakan Laravel 12
Middleware tidak didaftarkan di Http/Kernel.php
Semua middleware didaftarkan di bootstrap/app.php
