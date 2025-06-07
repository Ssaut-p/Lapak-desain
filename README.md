# 🎨 LapakDesain

Sebuah platform sederhana untuk jual beli jasa desain grafis secara online.

---

## ✨ Fitur

- ✅ Upload Project
- 🔔 Notifikasi Perkembangan Project
- 💳 Beli Project Desain
- 🌟 Ulasan Pembeli

---

## 🛠 Software & Teknologi

- **HTML**, **CSS**, **JavaScript** – Frontend tampilan pengguna
- **PHP** – Backend untuk proses server
- **MySQL** – Database penyimpanan data
- **Bootstrap 5** – Framework UI responsif
- **phpMyAdmin** – Manajemen database secara visual
- **XAMPP** – Server lokal untuk menjalankan Apache & MySQL

---

## 📦 Import Database (`ecommerce_project`)

1. Buka `http://localhost/phpmyadmin`
2. Klik tab **Database**, buat database baru dengan nama: `ecommerce_project`
3. Pilih database `ecommerce_project` yang baru dibuat
4. Klik tab **Import**
5. Pilih file `ecommerce_project.sql` dari komputermu
6. Klik **Go**

✅ Jika berhasil, semua tabel akan muncul di database `ecommerce_project`.

---

## 🚀 Penggunaan

1. **Registrasi User**  
   Masukkan nama, email, dan password pada halaman pendaftaran.

2. **Login**  
   Gunakan email dan password yang telah terdaftar untuk login ke sistem.

---

## 📁 Struktur Tabel Utama

- `users` – akun pengguna (desainer & pembeli)
- `projects` – project yang diunggah desainer
- `orders` – transaksi pembelian project
- `payments` – data pembayaran & bukti transfer
- `notifications` – pemberitahuan status project
- `reviews` – ulasan & rating dari pembeli

---

📌 Pastikan `XAMPP` aktif sebelum menjalankan project ini di `localhost`.

