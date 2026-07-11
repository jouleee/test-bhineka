# Sistem Informasi Invoice - PT. Bhinneka Sangkuriang Transport

Aplikasi Sistem Informasi Invoice berbasis web ini dirancang khusus untuk mengelola data transaksi, pelanggan, katalog produk, pengguna, dan mencetak invoice secara efisien. Aplikasi ini dibangun menggunakan framework **CodeIgniter 4** dengan arsitektur MVC (Model-View-Controller).

---

## 🚀 Fitur Utama

- **Autentikasi Multi-Level**: Login aman untuk berbagai peran/role (seperti *Admin*, *Purchasing*, *Finance*).
- **Dashboard Interaktif**: Statistik ringkas berupa total invoice terbit, jumlah pelanggan, jumlah produk, dan informasi keuangan penting lainnya.
- **Manajemen Invoice**:
  - Pembuatan invoice baru dengan penambahan item produk dinamis.
  - Cetak invoice dengan format kop surat resmi perusahaan.
  - Pelacakan status pembayaran invoice.
- **Manajemen Pelanggan (Customers)**: Pendataan pelanggan untuk mempermudah penargetan invoice.
- **Manajemen Produk/Layanan (Products)**: Pengelolaan katalog produk/layasan beserta harga satuan.
- **Manajemen Pengguna (Users)**: Pengelolaan akun pengguna yang berwenang mengakses sistem.
- **Pengaturan Profil Perusahaan (Settings)**: Konfigurasi nama, alamat, nomor telepon, dan email perusahaan untuk kop surat invoice secara dinamis.

---
### 1. Halaman Login
Halaman masuk bagi pengguna untuk mengakses sistem berdasarkan username dan password.
![Halaman Login](public/image/screenshots/login.png)

### 2. Dashboard Utama
Menampilkan ringkasan statistik data sistem seperti total invoice, produk, customer, dan user aktif.
![Dashboard Utama](public/image/screenshots/dashboard.png)

### 3. Daftar Invoice
Tabel yang menampilkan semua transaksi invoice beserta status, tanggal, dan aksi (detail, edit, hapus, cetak).
![Daftar Invoice](public/image/screenshots/invoice_list.png)

### 4. Pembuatan & Detail Invoice
Form pembuatan invoice baru dengan penambahan item secara dinamis serta cetak invoice.
![Form Pembuatan Invoice](public/image/screenshots/invoice_form.png)
![Detail & Cetak Invoice](public/image/screenshots/invoice_detail.png)

### 5. Manajemen Data (Customers, Products, Users)
Halaman master data untuk mengelola entitas pelanggan, produk, dan pengguna sistem.
![Manajemen Customer](public/image/screenshots/customers.png)
![Manajemen Produk](public/image/screenshots/products.png)

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP >= 8.2
- **Framework**: CodeIgniter 4.7+
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap 5 (CSS & JS), Custom Vanilla CSS
- **Dependency Manager**: Composer

---

## 💻 Langkah Instalasi & Setup

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

### 1. Clone atau Unduh Project
Pastikan Anda sudah mendownload source code ini dan mengekstraknya di direktori web server Anda (misal `htdocs` untuk XAMPP atau folder kerja Anda).

### 2. Install Dependensi PHP via Composer
Buka terminal/command prompt pada direktori project, lalu jalankan perintah berikut:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin atau ganti nama file `env` (bawaan project) menjadi `.env`:
```bash
cp env .env
```
Buka file `.env` menggunakan text editor, kemudian sesuaikan konfigurasi database berikut:
```env
# Mode Environment (ubah ke development saat pengembangan)
CI_ENVIRONMENT = development

# Konfigurasi URL Utama
app.baseURL = 'http://localhost:8080/'

# Konfigurasi Database
database.default.hostname = localhost
database.default.database = invoice_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Import Database
1. Buka **phpMyAdmin** atau DBMS favorit Anda (DBeaver, Navicat, dll.).
2. Buat database baru bernama `invoice_db`.
3. Import file `invoice.sql` yang terletak di root direktori project ini ke dalam database `invoice_db`.

### 5. Jalankan Local Development Server
Jalankan perintah berikut di terminal Anda untuk menyalakan server lokal bawaan CodeIgniter:
```bash
php spark serve
```
Buka browser Anda dan akses aplikasi melalui tautan:
👉 **[http://localhost:8080](http://localhost:8080)**

---
