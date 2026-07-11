# Sistem Informasi Invoice - PT. Bhinneka Sangkuriang Transport

Aplikasi Sistem Informasi Invoice berbasis web ini dirancang khusus untuk mengelola data transaksi, pelanggan, katalog produk, pengguna, dan mencetak invoice secara efisien. Aplikasi ini dibangun menggunakan framework **CodeIgniter 4** dengan arsitektur MVC (Model-View-Controller).

---

## Fitur Utama

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
## Desain Database
<img width="1308" height="757" alt="image" src="https://github.com/user-attachments/assets/629ec5cf-a748-4f20-94a6-b7aea4853cbf" />

---
## Screenshot Program
### 1. Halaman Login
Halaman masuk bagi pengguna untuk mengakses sistem berdasarkan username dan password.
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/70e2fea4-74b0-48d4-8c8f-061c27e264c0" />

### 2. Dashboard Utama
Menampilkan ringkasan statistik data sistem seperti total invoice, produk, dan customer.
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/430031ba-53bb-4328-86be-91792af03b2c" />

### 3. Daftar Invoice
Tabel yang menampilkan semua transaksi invoice beserta status, tanggal, dan aksi (detail, edit, hapus, cetak).
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/2d6449ff-a1cd-43f8-8547-9cbb2a3bb83e" />

### 4. Pembuatan & Detail Invoice
Form pembuatan invoice baru dengan penambahan item secara dinamis serta cetak invoice.
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/badfca34-9e43-41f4-be0b-e85d0c8a8f65" />
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/f71179f2-77f8-4c28-a39b-f1430232e20d" />

### 5. Manajemen Data (Customers, Products, Users)
Halaman master data untuk mengelola entitas pelanggan, produk, dan pengguna sistem.
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/fcaf3323-f1dd-4686-b3e4-d0298ce5d693" />
<img width="1920" height="912" alt="image" src="https://github.com/user-attachments/assets/30035f18-0ac5-42a6-8814-619ad6dcdaec" />


---

## Teknologi yang Digunakan

- **Backend**: PHP >= 8.2
- **Framework**: CodeIgniter 4.7+
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap 5 (CSS & JS), Custom Vanilla CSS
- **Dependency Manager**: Composer

---

## Langkah Instalasi & Setup

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
1. Buka **phpMyAdmin** atau DBMS Mysql Server lainnya.
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
