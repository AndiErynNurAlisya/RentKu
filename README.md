# Dokumentasi Teknis - RentKu

**Solusi Perjalanan Anda**

---

## 📋 Daftar Isi

1. [Tentang Aplikasi](#tentang-aplikasi)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Proyek](#struktur-proyek)
4. [Instalasi & Konfigurasi](#instalasi--konfigurasi)
5. [Fitur Aplikasi](#fitur-aplikasi)
6. [Alur Kerja Sistem](#alur-kerja-sistem)
7. [Database Schema](#database-schema)
8. [Notifikasi WhatsApp](#notifikasi-whatsapp)
9. [Troubleshooting](#troubleshooting)

---

## 🚗 Tentang Aplikasi

**RentKu** adalah aplikasi web rental kendaraan yang memudahkan pengguna untuk menemukan dan menyewa kendaraan (mobil dan motor) dengan cepat dan mudah.

### Tujuan Aplikasi

Mempermudah proses sewa-menyewa kendaraan dengan sistem booking online yang terintegrasi dengan notifikasi WhatsApp otomatis.

### Target Pengguna

Orang-orang yang membutuhkan kendaraan untuk disewa dengan cepat dan praktis.

### Fitur Utama

-   Pencarian kendaraan berdasarkan kategori, tanggal, dan ketersediaan
-   Sistem booking online dengan perhitungan biaya otomatis
-   Notifikasi WhatsApp otomatis untuk setiap status booking
-   Panel admin untuk manajemen kendaraan dan transaksi
-   Tracking kerusakan kendaraan
-   Riwayat transaksi pelanggan

---

## 🛠 Teknologi yang Digunakan

### Backend

-   **Framework**: Laravel 12.0
-   **PHP Version**: ^8.2
-   **Authentication**: Laravel Breeze (dimodifikasi sesuai kebutuhan)

### Frontend

-   **Template Engine**: Laravel Blade
-   **CSS Framework**: Tailwind CSS (bawaan Breeze)
-   **JavaScript**: Alpine.js (bawaan Breeze)

### Database

-   **Database**: MySQL
-   **Migration**: Laravel Migration System

### Third-Party Services

-   **WhatsApp API**: Fonnte.com (untuk notifikasi otomatis)

### Development Tools

-   **Package Manager**: Composer
-   **Queue System**: Laravel Queue (untuk pengiriman pesan)

---

## 📁 Struktur Proyek

```
rental-kendaraan/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                              # Controller untuk fitur admin
│   │   │   │   ├── CustomerController.php          # Manajemen pelanggan
│   │   │   │   ├── DashboardController.php         # Dashboard admin
│   │   │   │   ├── RentalController.php            # Manajemen transaksi rental
│   │   │   │   └── VehicleController.php           # Manajemen kendaraan
│   │   │   │
│   │   │   ├── Auth/                               # Controller autentikasi (Breeze)
│   │   │   │
│   │   │   └── Customer/                           # Controller untuk fitur customer
│   │   │       ├── HomeController.php              # Halaman utama & pencarian
│   │   │       ├── ProfileController.php           # Manajemen profil
│   │   │       ├── RentalController.php            # Booking & riwayat rental
│   │   │       └── VehicleController.php           # Detail kendaraan
│   │   │
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php                 # Proteksi route admin
│   │   │   └── CustomerMiddleware.php              # Proteksi route customer
│   │   │
│   │   └── Requests/                               # Form validation requests
│   │
│   ├── Jobs/
│   │   └── SendWhatsappMessage.php                 # Queue job untuk kirim WA
│   │
│   ├── Models/
│   │   ├── Damage.php                              # Model kerusakan kendaraan
│   │   ├── Rental.php                              # Model transaksi rental
│   │   ├── User.php                                # Model user (admin & customer)
│   │   └── Vehicle.php                             # Model kendaraan
│   │
│   ├── Notifications/
│   │   ├── Notifiables/
│   │   │   └── AdminNotifiable.php                 # Helper untuk notif admin
│   │   │
│   │   ├── NewOrderAdminNotification.php           # Notif ke admin saat ada booking baru
│   │   ├── NewOrderCustomerNotification.php        # Notif ke customer saat booking
│   │   ├── RentalApprovedNotification.php          # Notif saat booking disetujui
│   │   └── RentalCompletedNotification.php         # Notif saat rental selesai
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── NotificationChannelServiceProvider.php  # Register custom channel
│   │   └── ViewServiceProvider.php
│   │
│   ├── Services/
│   │   └── WhatsappChannel.php                     # Custom notification channel
│   │
│   └── View/Components/
│       └── Layouts/                                # Layout components
│           ├── Admin.php                           # Layout admin
│           ├── Customer.php                        # Layout customer
│           ├── AppLayout.php
│           └── GuestLayout.php
│
├── database/
│   ├── migrations/                                 # Database migrations
│   └── seeders/                                    # Database seeders
│
├── resources/
│   └── views/
│       ├── admin/                                  # Views untuk admin
│       │   ├── customers/                          # CRUD customers
│       │   ├── rentals/                            # Manajemen rental
│       │   ├── vehicles/                           # CRUD kendaraan
│       │   └── dashboard.blade.php
│       │
│       ├── auth/                                   # Views autentikasi
│       │
│       ├── customer/                               # Views untuk customer
│       │   ├── rentals/                            # Booking & riwayat
│       │   ├── vehicles/                           # Katalog kendaraan
│       │   ├── home.blade.php
│       │   └── profile.blade.php
│       │
│       ├── components/                             # Blade components
│       └── layouts/                                # Layout files
│
├── routes/
│   ├── web.php                                     # Route definitions
│   └── auth.php                                    # Route autentikasi (Breeze)
│
└── public/
    ├── images/                                     # Folder untuk gambar kendaraan
    └── dll
```

---

## ⚙️ Instalasi & Konfigurasi

### Prasyarat

-   PHP >= 8.2
-   Composer
-   Node.js
-   MySQL
-   Akun Fonnte.com (untuk WhatsApp API)

### Langkah Instalasi

#### 1. Clone Repository

```bash
git clone https://github.com/AndiErynNurAlisya/RentKu.git
cd rental-kendaraan
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### 3. Konfigurasi Environment

```bash
# Copy file .env.example
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rental_kendaraan
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Konfigurasi WhatsApp API (Fonnte)

Tambahkan di file `.env`:

```env
FONNTE_API_KEY=qpJ4ub43GQkqFyvbJ99N
FONNTE_URL=https://api.fonnte.com/send
```

#### 6. Jalankan Migration

```bash
php artisan migrate
```

#### 7. (Opsional) Seed Database

```bash
php artisan db:seed
```

#### 8. Setup Storage Link

```bash
php artisan storage:link
```

#### 9. Jalankan Aplikasi

Untuk development:

```bash
# Terminal 1: Server
php artisan serve

# Terminal 2: Queue Worker
php artisan queue:work
```

Aplikasi akan berjalan di: `http://127.0.0.1:8000`

---

## 🎯 Fitur Aplikasi

### 👤 Fitur Customer (Penyewa)

Customer adalah pengguna yang ingin menyewa kendaraan. Mereka dapat melakukan booking, melihat riwayat rental, dan mengelola profil mereka.

#### 1. 🔐 Autentikasi

-   **Register**: Daftar akun baru dengan data lengkap
    -   Nama lengkap
    -   Email (sebagai username)
    -   Password
-   **Login**: Masuk ke sistem menggunakan email dan password kemudian melenngkapi data diri berupa nomor telpon, Nomor KTP dan nomor SIM
-   **Logout**: Keluar dari sistem

#### 2. 🔍 Pencarian & Katalog Kendaraan

-   Melihat katalog lengkap kendaraan yang tersedia
-   **Filter kendaraan** berdasarkan:
    -   Kategori (Motor/Mobil)
    -   Tanggal mulai sewa
    -   Tanggal selesai sewa
    -   Hanya menampilkan kendaraan yang available pada range tanggal tersebut
-   Melihat detail kendaraan:
    -   Foto kendaraan
    -   Spesifikasi lengkap
    -   Harga per hari
    -   Status ketersediaan
    -   Deskripsi

#### 3. 📝 Booking Kendaraan

-   Memilih kendaraan yang ingin disewa
-   Menentukan tanggal rental:
    -   Tanggal mulai sewa
    -   Tanggal selesai sewa
-   **Sistem otomatis menghitung**:
    -   Total hari sewa
    -   Total biaya (durasi × harga per hari)
-   Submit booking ke sistem
-   **Menerima notifikasi WhatsApp** otomatis konfirmasi booking

#### 4. 📋 Manajemen Rental

Customer dapat memantau status booking mereka:

**Status yang dapat dilihat:**

-   🕐 **Menunggu Konfirmasi**: Menunggu konfirmasi admin
-   🚗 **Sedang berjalan**: Booking disetujui, siap diambil kendaraan
-   ✔️ **Selesai**: Sewa selesai, kendaraan sudah dikembalikan
-   ❌ **Batal**: Booking dibatalkan

**Fitur Manajemen:**

-   Melihat semua booking yang pernah dibuat
-   Melihat detail lengkap setiap transaksi:
    -   Info kendaraan yang disewa
    -   Tanggal rental
    -   Total biaya
    -   Status terkini
    -   Status pembayaran
-   Melihat riwayat rental (history)

#### 5. 👨‍💼 Profil Pengguna

-   Melihat data profil pribadi
-   **Edit data profil**:
    -   Nama lengkap
    -   Nomor telepon
    -   Nomor KTP
    -   Nomor SIM
-   **Ganti password**
-   Update informasi akun

---

### 🔧 Fitur Admin (Pengelola)

Admin adalah pengelola sistem yang bertanggung jawab mengelola kendaraan, pelanggan, dan transaksi rental. Admin memiliki akses penuh ke semua fitur manajemen.

#### 1. 📊 Dashboard Admin

Dashboard menyediakan overview lengkap tentang bisnis rental:

**Statistik Real-time:**

-   🚗 Total kendaraan (Motor & Mobil)
-   👥 Total kendaraan siap rental
-   📋 Total kendaraan sedang disew
-   📈 Total transaksi hari ini/minggu ini/bulan ini

**Daftar transaksi terbaru**
**Quick Actions**

#### 2. 👥 Manajemen Pelanggan

Admin dapat mengelola semua data pelanggan:

**Daftar Pelanggan:**

-   Melihat list semua pelanggan yang terdaftar
-   Informasi yang ditampilkan:
    -   Nama lengkap
    -   Email & nomor telepon
    -   Tanggal registrasi
    -   Total transaksi
    -   Identitas

**Detail Pelanggan:**

-   Melihat profil lengkap pelanggan:
    -   Data pribadi (nama, email, telepon, KTP, SIM)
    -   Riwayat transaksi rental
-   Melihat kendaraan yang sedang/selesai disewa

#### 3. 🚙 Manajemen Kendaraan

Admin dapat melakukan CRUD lengkap untuk kendaraan:

**Tambah Kendaraan Baru (Create):**

-   Input data kendaraan:
    -   Nama/model kendaraan
    -   Kategori (Motor/Mobil)
    -   Nomor plat (unique)
    -   Harga sewa per hari
    -   Status awal (Available/Maintenance)
    -   Upload foto kendaraan
    -   Deskripsi/spesifikasi lengkap

**Lihat Daftar Kendaraan (Read):**

-   List semua kendaraan dengan info:
    -   Foto thumbnail
    -   Nama & kategori
    -   Plat nomor
    -   Harga per hari
    -   Status terkini (badge berwarna)

**Edit Kendaraan (Update):**

-   Update semua data kendaraan
-   **Ubah status kendaraan:**
    -   🟢 **Tersedia**: Tersedia untuk disewa
    -   🔴 **Disewa**: Sedang disewa (otomatis saat rental ongoing)
    -   🟡 **Maintenance**: Dalam perbaikan/perawatan
-   Ganti foto kendaraan
-   Update harga

**Hapus Kendaraan (Delete):**

-   Soft delete (data tetap ada tapi tidak ditampilkan)
-   Validasi: tidak bisa hapus kendaraan yang sedang disewa

#### 4. 💳 Manajemen Rental/Transaksi

Admin mengelola semua transaksi rental dari awal hingga selesai:

**Daftar Transaksi:**

-   List semua booking/rental
-   **Filter berdasarkan status:**
    -   Pending (perlu action)
    -   Aktif
    -   Selesai
    -   Dibatalkan

**Detail Transaksi:**
Melihat informasi lengkap:

-   Data customer (nama, telepon, KTP, SIM)
-   Data kendaraan (nama, plat)
-   Periode rental (start date - end date)
-   Total hari sewa
-   Total biaya
-   Catatan tambahan jika ada kerusakan

**Action Admin pada Transaksi:**

1. **Konfirmasi Booking** (Pending → Approved)

    - Admin review booking baru
    - Cek ketersediaan kendaraan
    - Approve atau Reject
    - Sistem kirim notifikasi WA ke customer

2. **Mulai Rental** (Approved → Ongoing)

    - Customer datang ambil kendaraan
    - Customer bayar cash
    - Admin klik "Setujui transaksi"
    - Status kendaraan otomatis jadi "Disewa"
    - Sistem catat waktu mulai sewa

3. **Selesaikan Rental** (Ongoing → Completed)

    - Customer kembalikan kendaraan
    - Admin cek kondisi kendaraan
    - Jika ada kerusakan: catat di sistem damage
    - Admin klik "Selesaikan transaksi"
    - Status kendaraan otomatis kembali "Tersedia"
    - Sistem kirim notifikasi WA terima kasih ke customer

4. **Batalkan Booking** (Pending → Cancelled)
    - Admin bisa cancel booking jika diperlukan
    - Beri alasan pembatalan
    - Sistem kirim notifikasi ke customer

---

### 📊 Ringkasan Perbedaan Akses

| Fitur                            | Customer                      | Admin                                      |
| -------------------------------- | ----------------------------- | ------------------------------------------ |
| **Dashboard**                    | ❌ Tidak ada                  | ✅ Dashboard lengkap dengan statistik      |
| **Lihat Katalog Kendaraan**      | ✅ Ya                         | ✅ Ya                                      |
| **Filter & Cari Kendaraan**      | ✅ Ya                         | ✅ Ya                                      |
| **Booking Kendaraan**            | ✅ Ya                         | ❌ Tidak (admin tidak bisa booking)        |
| **Lihat Riwayat Rental Sendiri** | ✅ Ya                         | ❌ Tidak relevan                           |
| **Kelola Semua Transaksi**       | ❌ Tidak                      | ✅ Ya (semua transaksi semua customer)     |
| **Konfirmasi Booking**           | ❌ Tidak                      | ✅ Ya                                      |
| **Ubah Status Rental**           | ❌ Tidak                      | ✅ Ya (Start/Complete/Cancel)              |
| **CRUD Kendaraan**               | ❌ Tidak                      | ✅ Ya                                      |
| **Ubah Status Kendaraan**        | ❌ Tidak                      | ✅ Ya (Available/Rented/Maintenance)       |
| **Lihat Data Pelanggan**         | ❌ Tidak                      | ✅ Ya (semua pelanggan)                    |
| **Edit Profil Sendiri**          | ✅ Ya                         | ✅ Ya                                      |
| **Catat Kerusakan**              | ❌ Tidak                      | ✅ Ya                                      |
| **Lihat Riwayat Kerusakan**      | ❌ Tidak                      | ✅ Ya                                      |
| **Notifikasi WhatsApp**          | ✅ Ya (untuk booking sendiri) | ❌ Tidak (nomor admin dipakai untuk kirim) |

---

## 🗄️ Database Schema

### Tabel: users

Menyimpan data pengguna (admin dan customer)

| Field           | Type      | Deskripsi             |
| --------------- | --------- | --------------------- |
| id              | BIGINT    | Primary key           |
| name            | VARCHAR   | Nama lengkap          |
| email           | VARCHAR   | Email (unique)        |
| password        | VARCHAR   | Password (encrypted)  |
| phone           | VARCHAR   | Nomor telepon/WA      |
| identity_number | VARCHAR   | Nomor KTP             |
| driver_license  | VARCHAR   | Nomor SIM             |
| role            | ENUM      | admin / customer      |
| created_at      | TIMESTAMP | Waktu registrasi      |
| updated_at      | TIMESTAMP | Waktu update terakhir |
| remember_token  | VARCHAR   | Remember token        |

### Tabel: vehicles

Menyimpan data kendaraan

| Field         | Type      | Deskripsi             |
| ------------- | --------- | --------------------- |
| id            | BIGINT    | Primary key           |
| brand         | VARCHAR   | Merek kendaraan       |
| type          | VARCHAR   | Tipe kendaraan        |
| category      | ENUM      | motor / mobil         |
| plate_number  | VARCHAR   | Plat nomor (unique)   |
| price_per_day | DECIMAL   | Harga per hari        |
| status        | VARCHAR   | Status kendaraan      |
| image         | VARCHAR   | Path foto kendaraan   |
| description   | TEXT      | Spesifikasi/deskripsi |
| created_at    | TIMESTAMP | Waktu ditambahkan     |
| updated_at    | TIMESTAMP | Waktu update terakhir |

### Tabel: rentals

Menyimpan transaksi rental

| Field       | Type      | Deskripsi                                |
| ----------- | --------- | ---------------------------------------- |
| id          | BIGINT    | Primary key                              |
| Rental code | VARCHAR   | Kode Rental                              |
| user_id     | BIGINT    | Foreign key ke users                     |
| vehicle_id  | BIGINT    | Foreign key ke vehicles                  |
| start_date  | DATE      | Tanggal mulai sewa                       |
| end_date    | DATE      | Tanggal selesai sewa                     |
| total_days  | INT       | Durasi sewa (hari)                       |
| total_price | DECIMAL   | Total biaya                              |
| status      | ENUM      | pending / active / completed / cancelled |
| notes       | TEXT      | Catatan tambahan                         |
| created_at  | TIMESTAMP | Waktu booking                            |
| updated_at  | TIMESTAMP | Waktu update terakhir                    |

### Tabel: damages

Menyimpan data kerusakan kendaraan

| Field       | Type      | Deskripsi              |
| ----------- | --------- | ---------------------- |
| id          | BIGINT    | Primary key            |
| rental_id   | BIGINT    | Foreign key ke rentals |
| description | TEXT      | Deskripsi kerusakan    |
| damage_cost | DECIMAL   | Biaya kerusakan        |
| image       | VARCHAR   | Path foto kerusakan    |
| reported_at | TIMESTAMP | Waktu laporan          |
| created_at  | TIMESTAMP | Waktu dibuat           |
| updated_at  | TIMESTAMP | Waktu update terakhir  |

### Relasi Antar Tabel

```
users (1) ──────< (N) rentals
                       │
vehicles (1) ──────< (N) rentals
                       │
rentals (1) ─────< (N) damages
```

---

## 📱 Notifikasi WhatsApp

### Integrasi dengan Fonnte API

RentKu menggunakan **Fonnte.com** sebagai gateway untuk mengirim notifikasi WhatsApp otomatis.

### Konfigurasi

1. Daftar/login ke https://fonnte.com
2. Dapatkan API key dari dashboard
3. Tambahkan ke `.env`:

```env
FONNTE_API_KEY=qpJ4ub43GQkqFyvbJ99N
FONNTE_URL=https://api.fonnte.com/send
```

### Custom Notification Channel

Aplikasi menggunakan custom notification channel (`WhatsappChannel`) untuk mengirim pesan melalui Fonnte API.

**File**: `app/Services/WhatsappChannel.php`

### Jenis Notifikasi

#### 1. NewOrderCustomerNotification

**Kapan**: Saat customer melakukan booking baru
**Dikirim ke**: Customer (nomor dari tabel users)
**Isi pesan**:

```
Halo [nama cust],
Pesanan Anda berhasil dibuat dan statusnya PENDING!

Kode Booking: [kode rental]
Kendaraan: [nama kendaraan]
Total Biaya: Rp [total sewa]

Admin kami akan segera memproses persetujuan. Kami akan memberitahu Anda setelah statusnya ACTIVE. Terima kasih!

> Sent via fonnte.com
```

#### 2. RentalApprovedNotification

**Kapan**: Saat admin menyetujui booking
**Dikirim ke**: Customer
**Isi pesan**:

```
✅ KONFIRMASI BOOKING RENTKU 

Halo [nama cust],
Permintaan sewa Anda untuk [nama kendaraan] telah DISETUJUI oleh Admin.

Kode Sewa: [kode rental]
Tanggal Sewa: [tanggal mulai] s/d [tanggal selesai]

Mohon ambil kendaraan tepat waktu. Terima kasih.

> Sent via fonnte.com
```

#### 3. RentalCompletedNotification

**Kapan**: Saat admin menyelesaikan transaksi rental
**Dikirim ke**: Customer
**Isi pesan**:

```
🎉 Transaksi Selesai - RentKu 🎉

Kepada Yth. [nama cust],
Kode Booking: [kode rental]
Kendaraan: [nama kendaraan]

Kendaraan telah berhasil dikembalikan pada tanggal 26/11/2025 00:00.
---------------------------------------
🏷 RINGKASAN BIAYA
Sewa Dasar (total hari): Rp [total sewa]
⚠ Biaya Kerusakan: + Rp [biaya kerusakan]
---------------------------------------
💰 TOTAL TAGIHAN AKHIR: Rp [total tagihan]

ℹ Catatan: Biaya tambahan (denda/kerusakan) telah ditambahkan ke total akhir. Mohon cek detail transaksi Anda.

Terima kasih atas kepercayaan Anda. Kami nantikan pemesanan Anda selanjutnya!

> Sent via fonnte.com
```

### Queue System

Notifikasi WhatsApp dikirim menggunakan **Laravel Queue** untuk menghindari blocking request.

**Job**: `app/Jobs/SendWhatsappMessage.php`

Untuk menjalankan queue worker:

```bash
php artisan queue:work
```

---

## 🐛 Troubleshooting

### Masalah Umum

#### 1. Notifikasi WhatsApp Tidak Terkirim

**Penyebab**:

-   API key Fonnte salah atau expired
-   Queue worker tidak berjalan
-   Nomor telepon tidak valid

**Solusi**:

```bash
# Cek queue worker
php artisan queue:work

# Cek log error
tail -f storage/logs/laravel.log

# Test koneksi Fonnte API
curl -X POST https://api.fonnte.com/send \
  -H "Authorization: YOUR_API_KEY" \
  -d "target=6281234567890&message=Test"
```

#### 2. Error Saat Upload Gambar

**Penyebab**: Storage link belum dibuat

**Solusi**:

```bash
php artisan storage:link
```

#### 3. Error Migration

**Penyebab**: Database belum dibuat

**Solusi**:

```bash
# Buat database manual di MySQL
mysql -u root -p
CREATE DATABASE rentku;

# Jalankan migration lagi
php artisan migrate
```

#### 4. Error 419 (CSRF Token Mismatch)

**Penyebab**: Session expired atau cache issue

**Solusi**:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 5. Asset Tidak Load

**Penyebab**: Assets belum di-build

**Solusi**:

```bash
npm run build
```

---
### Changelog

**Version 1.0.0** (Current)

-   Fitur booking kendaraan
-   Notifikasi WhatsApp otomatis
-   Panel admin lengkap
-   Tracking kerusakan kendaraan

---

**© 2025 RentKu - Solusi Perjalanan Anda**
