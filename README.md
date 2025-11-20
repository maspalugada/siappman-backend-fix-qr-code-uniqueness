# SiAPPMan - Aplikasi Manajemen Aset dan Kode QR

SiAPPMan (Sistem Aplikasi Manajemen Aset) adalah aplikasi web yang dirancang untuk membantu organisasi melacak dan mengelola aset mereka secara efisien melalui penggunaan kode QR. Aplikasi ini dibangun dengan Laravel dan menyediakan antarmuka yang modern, minimalis, dan responsif.

## Gambaran Umum Fitur

- **Manajemen Aset:** Tambah, lihat, edit, dan hapus aset seperti peralatan, instrumen, dan perlengkapan.
- **Pembuatan Kode QR:** Secara otomatis menghasilkan kode QR unik untuk setiap aset, sehingga memudahkan pelacakan.
- **Riwayat Pemindaian:** Catat setiap pemindaian kode QR, berikan jejak audit lengkap tentang siapa yang memindai apa, di mana, dan kapan.
- **Manajemen Pengguna:** Sistem berbasis peran untuk mengontrol akses ke berbagai fitur.
- **Antarmuka Responsif:** Bekerja dengan lancar di perangkat desktop dan seluler.

## Prasyarat untuk Penyiapan Lokal

Sebelum Anda memulai, pastikan sistem Anda memenuhi persyaratan berikut:

- **Docker Desktop:** Aplikasi ini menggunakan Laravel Sail, lingkungan pengembangan berbasis Docker. [Instal Docker Desktop](https://www.docker.com/products/docker-desktop).
- **Composer:** Manajer dependensi untuk PHP. [Instal Composer](https://getcomposer.org/download/).
- **Node.js dan NPM:** Diperlukan untuk mengelola dependensi frontend dan menjalankan server pengembangan Vite. [Instal Node.js](https://nodejs.org/en/download/).
- **Git:** Untuk mengkloning repositori.

## Panduan Penyiapan Lokal

Ikuti langkah-langkah ini untuk menjalankan aplikasi di mesin lokal Anda.

### 1. Kloning Repositori

Buka terminal Anda dan kloning repositori ini ke direktori lokal Anda:

```bash
git clone <URL_REPOSITORI>
cd <NAMA_DIREKTORI_PROYEK>
```

### 2. Salin File Environment

Salin file `.env.example` untuk membuat file `.env` Anda sendiri. File ini akan menyimpan konfigurasi spesifik lingkungan Anda.

```bash
cp .env.example .env
```

### 3. Instal Dependensi

Aplikasi ini memiliki dependensi backend (PHP) dan frontend (JavaScript).

**a. Instal Dependensi Composer (PHP):**

```bash
composer install
```

**b. Instal Dependensi NPM (JavaScript):**

```bash
npm install
```

### 4. Buat Alias untuk Sail

Untuk memudahkan eksekusi perintah Sail, buat alias bash:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

### 5. Jalankan Aplikasi dengan Laravel Sail

Sail akan secara otomatis membangun dan menjalankan kontainer Docker yang diperlukan.

```bash
sail up -d
```
*(Flag `-d` menjalankan kontainer dalam mode detached (di latar belakang).)*

### 6. Jalankan Migrasi Database

Setelah kontainer berjalan, jalankan migrasi database untuk membuat semua tabel yang diperlukan.

```bash
sail artisan migrate
```

### 7. Jalankan Server Pengembangan Vite

Untuk mengkompilasi aset frontend seperti CSS dan JavaScript, jalankan server pengembangan Vite.

```bash
npm run dev
```

### 8. Akses Aplikasi

Sekarang Anda dapat mengakses aplikasi di browser Anda. Biasanya, server pengembangan Vite akan berjalan di `http://localhost:5173`.

---

## Cara Menggunakan Aplikasi

- **Login/Register:** Buat akun untuk mulai menggunakan aplikasi. Peran default termasuk Admin dan Staf, dengan izin yang telah dikonfigurasi sebelumnya.
- **Dasbor:** Setelah login, Anda akan disambut dengan dasbor, yang menyediakan navigasi cepat ke fitur-fitur utama.
- **Manajemen Aset:** Navigasikan ke bagian "Aset" untuk menambahkan aset baru. Isi detail seperti nama, lokasi, dan jumlah. Kode QR akan secara otomatis dibuat untuk setiap unit aset.
- **Mencetak Kode QR:** Di bagian "Kode QR", Anda dapat melihat, mengunduh, atau mencetak kode QR untuk setiap aset.
- **Memindai Aset:** Gunakan fitur "Pemindai" (terbaik di perangkat seluler) untuk memindai kode QR aset. Ini akan mencatat aktivitas pemindaian dan memungkinkan Anda memperbarui status aset.
- **Melihat Riwayat:** Kunjungi "Riwayat Pemindaian" untuk melihat catatan terperinci dari semua aktivitas pemindaian di seluruh organisasi.
