# Panduan Lengkap Deploy Proyek Sosro Career ke aaPanel Menggunakan Docker

Panduan ini memandu Anda langkah demi langkah untuk men-deploy aplikasi **Sosro Career** ke server VPS menggunakan **aaPanel** dan **Docker Compose**.

---

## Ringkasan Alur Kerja

```
Domain Publik (e.g. karir.perusahaan.com)
             │  (Port 80/443 + SSL Let's Encrypt)
             ▼
      aaPanel Nginx (Reverse Proxy)
             │  Forward ke http://127.0.0.1:8080
             ▼
   Docker Container: Nginx (Port 8080)
             │  FastCGI
             ▼
   Docker Container: PHP 8.4-FPM (Laravel) + MySQL + Queue Worker + Cron
```

---

## Bagian 1: Persiapan di aaPanel

1. **Buka Dashboard aaPanel** Anda melalui browser.
2. Masuk ke menu **App Store**:
   - Cari dan install **Docker** (atau **Docker Manager**).
   - Pastikan layanan Docker berstatus running.
3. Buka menu **Security** di aaPanel:
   - Pastikan port `80` dan `443` sudah terbuka di firewall.
   *(Port `8080` tidak perlu dibuka ke publik jika menggunakan Reverse Proxy aaPanel).*

---

## Bagian 2: Clone Repository ke Server

Buka **Terminal** di aaPanel (menu *Terminal* di sidebar kiri), lalu jalankan:

```bash
# 1. Pindah ke direktori web aaPanel
cd /www/wwwroot

# 2. Clone repository proyek Anda
git clone https://github.com/USERNAME/REPO-NAME.git pro_sosro-career

# 3. Masuk ke folder proyek
cd pro_sosro-career
```

---

## Bagian 3: Konfigurasi File Environment (.env)

Salin contoh file environment dan sesuaikan konfigurasinya:

```bash
cp .env.example .env
nano .env
```

Sesuaikan parameter-parameter berikut di dalam file `.env`:

```ini
APP_NAME="Sosro Career"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://karir.domainanda.com

# Port web container yang dipetakan ke host
APP_PORT=8080

# Konfigurasi Database (Gunakan service Docker "db" bawaan)
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=pro_sosro-career
DB_USERNAME=sosro_user
DB_PASSWORD=GantiDenganPasswordKuat123!
DB_ROOT_PASSWORD=GantiDenganPasswordRootKuat123!

# Antrean & Cache
QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database

# Konfigurasi Pengiriman Email (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=app_password_gmail_anda
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> **Catatan:** Tekan `Ctrl + O` lalu `Enter` untuk menyimpan, kemudian `Ctrl + X` untuk keluar dari nano.

---

## Bagian 4: Build & Jalankan Container Docker

Jalankan perintah ini di dalam direktori `/www/wwwroot/pro_sosro-career`:

```bash
# Build image dan nyalakan semua container di background
docker compose up -d --build
```

Cek apakah seluruh container telah berjalan dengan baik:

```bash
docker compose ps
```

Anda akan melihat 5 container aktif:
- `sosro_career_web` (Nginx, port `8080`)
- `sosro_career_app` (PHP 8.4-FPM)
- `sosro_career_queue` (Worker email/antrean)
- `sosro_career_cron` (Scheduler per menit)
- `sosro_career_db` (MySQL 8.0)

---

## Bagian 5: Inisialisasi Aplikasi (Key, Migration & Seed)

Jalankan perintah inisialisasi berikut ke dalam container `app`:

```bash
# 1. Generate Application Encryption Key
docker compose exec app php artisan key:generate

# 2. Jalankan Migrasi Database (termasuk 9 tabel HRIS dan email log)
docker compose exec app php artisan migrate --force

# 3. Jalankan Seeder Database (Akun Admin default & Stages rekrutmen)
docker compose exec app php artisan db:seed --force

# 4. Pastikan symlink storage terpasang
docker compose exec app php artisan storage:link --force

# 5. Optimasi cache produksi
docker compose exec app php artisan optimize
```

---

## Bagian 6: Menghubungkan Domain di Dashboard aaPanel (Reverse Proxy & SSL)

1. **Tambah Website**:
   - Di dashboard aaPanel, klik menu **Website** &rarr; **Add Site**.
   - **Domain**: Masukkan domain Anda (misal: `karir.domainanda.com`).
   - **PHP Version**: Pilih `pure static` (karena PHP sudah di-handle di dalam Docker).
   - Klik **Submit**.

2. **Atur Reverse Proxy**:
   - Pada baris domain yang baru dibuat, klik nama domain untuk membuka **Site Settings**.
   - Pilih tab **Reverse Proxy** di menu kiri &rarr; klik **Add Reverse Proxy**.
   - Isi form:
     - **Proxy Name**: `docker_sosro`
     - **Target URL**: `http://127.0.0.1:8080`
     - **Sent Domain**: `$host`
   - Klik **Save**.

3. **Pasang Sertifikat SSL (HTTPS)**:
   - Masih di **Site Settings**, klik tab **SSL**.
   - Pilih tab **Let's Encrypt**.
   - Centang domain Anda, lalu klik **Apply**.
   - Setelah sertifikat berhasil dibuat, aktifkan toggle **Force HTTPS**.

🎉 **Selesai!** Buka browser dan akses `https://karir.domainanda.com`.
Aplikasi Sosro Career Anda sekarang sudah online dengan HTTPS aman, performa Nginx Docker yang terisolasi, antrean email otomatis, dan database persisten.

---

## Bagian 7: Perintah Maintenance & Pembaruan (Update Code)

### Cara Melihat Log Container
```bash
# Log pengiriman email & antrean worker
docker compose logs -f queue

# Log aplikasi web / Nginx
docker compose logs -f web

# Log PHP-FPM
docker compose logs -f app
```

### Cara Update Kode Terbaru dari Git di Kemudian Hari
```bash
cd /www/wwwroot/pro_sosro-career
git pull origin main

# Re-build jika ada perubahan package/aset
docker compose up -d --build

# Jalankan migrasi jika ada migrasi baru
docker compose exec app php artisan migrate --force

# Re-cache config & route
docker compose exec app php artisan optimize
```

### Cara Restart Layanan
```bash
docker compose restart
```

### Cara Masuk ke Terminal Container (Tinker / Debug)
```bash
docker compose exec app php artisan tinker
# atau masuk ke bash shell container
docker compose exec app sh
```
