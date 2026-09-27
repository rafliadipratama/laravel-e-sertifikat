# Laravel E-Sertifikat Digital

Aplikasi berbasis web untuk manajemen kegiatan, penerbitan sertifikat digital otomatis, ekspor berkas PDF lanskap resmi, dan verifikasi keaslian dokumen via QR Code.

---

## Fitur Utama

1. **Manajemen Acara & Penyelenggara**
   - Tambah, edit, dan kelola data kegiatan (workshop, webinar, pelatihan, kompetisi).
   - Penentuan awalan (prefix) nomor sertifikat dinamis per kegiatan.
   - Konfigurasi penandatangan resmi (nama dan jabatan).

2. **Penerbitan Sertifikat Peserta**
   - **Penerbitan Satuan**: Input satu per satu penerima dengan nomor sertifikat otomatis.
   - **Penerbitan Massal (Bulk)**: Input puluhan peserta sekaligus via format baris teks (Nama, Email, Peran).
   - Penomoran sertifikat urut otomatis sesuai format kegiatan.

3. **Cetak & Ekspor PDF Berkualitas Tinggi**
   - Layout sertifikat resmi ukuran A4 Lanskap (297mm x 210mm).
   - Ornamen bingkai ganda elegan (navy & gold accent).
   - Dilengkapi QR Code digital resmi yang tertaut langsung ke URL verifikasi keaslian dokumen.
   - Opsi Preview langsung di peramban atau Unduh (Download) berkas PDF.

4. **Pusat Verifikasi Keaslian Publik**
   - Halaman pencarian publik untuk memeriksa validitas dokumen menggunakan Nomor Sertifikat atau Token Unik.
   - Status verifikasi instan: "Terverifikasi Valid" lengkap dengan detail acara, penerima, dan tanggal penerbitan.
   - Pindai QR Code langsung mengarahkan ke halaman keabsahan dokumen.

---

## Kebutuhan Sistem

- PHP 8.3 atau lebih baru (ekstensi: `pdo_sqlite` / `pdo_mysql`, `gd`, `mbstring`, `fileinfo`, `openssl`)
- Composer 2.x
- Node.js & npm (opsional untuk build styling lokal)

---

## Panduan Instalasi Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/rafliadipratama/laravel-e-sertifikat.git
   cd laravel-e-sertifikat
   ```

2. **Pasang Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin `.env.example` ke `.env` dan buat APP_KEY:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Jalankan Migrasi & Data Contoh (Seed)**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Buka peramban di `http://localhost:8000`.

---

## Lisensi

Proyek ini berlisensi [MIT](LICENSE).
