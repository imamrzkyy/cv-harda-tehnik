# CV. Harda Tehnik Mandiri

Website profil + sistem booking untuk **CV. Harda Tehnik Mandiri** — jasa perawatan, perbaikan, dan pemasangan AC. Dibangun dengan PHP native + MySQL, di-deploy otomatis via GitHub Actions ke server produksi.

**🌐 Live:** [https://hardatehnikmandiri.my.id/](https://hardatehnikmandiri.my.id/)

---

## Fitur

**Halaman Publik (user)**
- Beranda dengan hero, keunggulan, layanan, produk, galeri, testimoni & FAQ
- Katalog **Layanan** (cuci AC, service, isi freon, bongkar/pasang, dll.)
- Katalog **Produk** (AC baru & bekas) + halaman detail
- **Booking layanan** online (pilih layanan, tanggal, jam, keluhan)
- Registrasi & login user
- Dashboard user, riwayat booking, profil (upload foto)
- Form **kontak** & testimoni

**Admin Panel** (`/admin`)
- Dashboard ringkasan
- Kelola **booking** (proses, selesai, batalkan, pembayaran)
- Kelola **layanan**, **produk**, **kategori**, **galeri**, **testimoni**, **pelanggan**
- Laporan & pengaturan website

**Teknis**
- PHP 8.2 native + MySQL/MariaDB
- Bootstrap 5 + Bootstrap Icons + Google Fonts
- Env-based config dengan fallback ke nilai default
- Containerized (Docker) + Cloudflare Tunnel (tanpa port terbuka)

---

## Struktur Proyek

```
├── index.php               # Halaman utama (publik)
├── produk.php              # Katalog produk
├── detail_produk.php       # Detail produk
├── admin/                  # Panel admin
├── user/                   # Halaman user (booking, profil, dll.)
├── includes/               # Header, navbar, footer bersama
├── config/                 # koneksi DB, helper (base_url)
│   ├── koneksi.php         # Koneksi DB (env-based, fallback localhost)
│   └── helper.php          # base_url otomatis dari host
├── assets/                 # CSS, JS, gambar (logo, hero, galeri, team)
├── uploads/                # Foto user & produk (volume Docker, persist)
├── Dockerfile              # Image php:8.2-apache + ekstensi
├── docker-compose.yml      # app + cloudflared sidecar
├── .env.example            # Template env (salin ke .env)
└── .github/workflows/      # CI/CD: deploy otomatis
```

---

## Konfigurasi Aplikasi (`.env`)

Config database dibaca dari **environment variable**, dengan fallback ke nilai hardcode (`localhost`) jika tidak ada.

| Variabel | Fallback (jika kosong) | Keterangan |
|---|---|---|
| `DB_HOST` | `localhost` | Host database |
| `DB_USERNAME` | `root` | User database |
| `DB_PASSWORD` | *(kosong)* | Password database |
| `DB_DATABASE` | `db_harda_tehnik` | Nama database |
| `CLOUDFLARED_TOKEN` | *(wajib diisi)* | Token tunnel Cloudflare |

`base_url` di `config/helper.php` dihitung otomatis dari `$_SERVER['HTTP_HOST']` (HTTP/HTTPS), sehingga tidak perlu diubah saat pindah domain.

Contoh `.env`:

```bash
# Salin dari .env.example lalu isi
MYSQL_DATABASE=db_harda_tehnik
MYSQL_USER=harda_user
MYSQL_PASSWORD=password_kuat
CLOUDFLARED_TOKEN=token_tunnel_cloudflare
```

> ⚠️ Repo ini **public**. Jangan commit `.env` — sudah di-ignore via `.gitignore`. Secret produksi disimpan di GitHub Secrets & di server.

---

## Database

Dump SQL tersedia di `db_harda_tehnik.sql` (di luar repo — dikelola di server). Skema berisi 12 tabel:

`admin`, `booking`, `galeri`, `kategori_layanan`, `kategori_produk`, `kontak`, `layanan`, `penawaran_ac`, `pengaturan`, `produk`, `testimoni`, `user`

### Akses admin bawaan

| Email | Password |
|---|---|
| `admin@hardatehnik.com` | *(lihat isi dump / ganti di DB)* |

> Ganti password default setelah deploy pertama.

---

## Menjalankan Secara Lokal (XAMPP / Laragon)

1. Clone repo & letakkan di `htdocs/`
2. Import `db_harda_tehnik.sql` ke phpMyAdmin (buat DB `db_harda_tehnik`)
3. Tanpa `.env`, app otomatis pakai fallback `localhost`/`root`/tanpa password
4. Buka `http://localhost/<folder>/`
5. (Opsional) Set env var untuk kustomisasi DB

## Menjalankan dengan Docker (Local)

```bash
# Siapkan env
cp .env.example .env
# isi .env sesuai kebutuhan

# Build & jalankan hanya app
docker compose up -d --build app
# → http://localhost:80
```

---

## Deployment (CI/CD) — Server Produksi

Server: **sewa-server** (`51.79.231.130:10268`) · directory: `/home/ubuntu/sewa/cv-harda-tehnik`

### Alur deploy

```
push ke branch main (github.com/imamrzkyy/cv-harda-tehnik)
        │
        ▼
GitHub Actions (.github/workflows/deploy.yml)
        │ 1. SSH ke server
        │ 2. git fetch + git reset --hard origin/main  (source of truth = GitHub)
        │ 3. Tulis .env dari GitHub Secrets
        │ 4. chown uploads (www-data)
        │ 5. docker compose up -d --build (app + cloudflared)
        ▼
Live: https://hardatehnikmandiri.my.id/
```

### Cara deploy

**Otomatis** — cukup `git push` ke `main`. Tidak ada langkah manual lain.

```bash
git add .
git commit -m "update fitur"
git push origin main
```

**Manual (jika perlu)** — jalankan dari tab Actions → *Deploy cv-harda-tehnik* → *Run workflow*, atau langsung di server:

```bash
ssh root@51.79.231.130 -p 10268
cd /home/ubuntu/sewa/cv-harda-tehnik
git pull origin main
docker compose up -d --build app
```

### GitHub Secrets yang wajib diset

Karena repo **public**, semua credential disimpan sebagai **GitHub Secrets** (Settings → Secrets and variables → Actions):

| Secret | Nilai contoh |
|---|---|
| `SERVER_HOST` | `51.79.231.130` |
| `SERVER_PORT` | `10268` |
| `SERVER_USER` | `root` |
| `SERVER_PASSWORD` | *(password SSH server)* |
| `DB_PASSWORD` | *(password MySQL user app)* |
| `CLOUDFLARED_TOKEN` | *(token tunnel Cloudflare)* |

> Jika salah satu secrets kosong, workflow akan gagal di step *Deploy via SSH*.

### Infrastruktur di server

- **App**: container `cv-harda-tehnik-app` (`php:8.2-apache`, ekstensi mysqli/pdo/gd/zip/mbstring)
- **Tunnel**: container `cv-harda-tehnik-cloudflared` (token-based, hostname di dashboard Zero Trust)
- **Database**: shared `infra-mysql` (MySQL 8.4) di network `db-shared` — dipakai bareng app lain
- **Volume**: `./uploads` di-mount ke container agar foto user/produk persisten
- `.env` produksi **disimpan di server** (dibuat ulang oleh workflow dari secrets), bukan di repo

---

## Teknologi

| Layer | Teknologi |
|---|---|
| Frontend | HTML5, CSS3, Bootstrap 5, Bootstrap Icons, Google Fonts, JavaScript |
| Backend | PHP 8.2 (native, mysqli) |
| Database | MySQL 8.4 / MariaDB 10.4 |
| Runtime | Docker (php:8.2-apache) |
| Jaringan | Cloudflare Tunnel (Zero Trust) |
| CI/CD | GitHub Actions |

---

## Troubleshooting

**`DNS_PROBE_POSSIBLE` saat buka domain**
Flush DNS lokal (`ipconfig /flushdns` di Windows, `dscacheutil -flushcache` di macOS) atau buka di private window.

**Situs 502/error setelah deploy**
Cek container di server: `docker ps --filter name=cv-harda-tehnik` dan `docker logs cv-harda-tehnik-app --tail 50`.

**Koneksi DB gagal**
Pastikan database `db_harda_tehnik` + user ada di `infra-mysql`, dan `.env` di server berisi `MYSQL_PASSWORD` yang benar.

**Workflow gagal "missing server host"**
Belum semua GitHub Secrets diset (lihat tabel secrets di atas).

---

## Lisensi

Proyek internal — **CV. Harda Tehnik Mandiri**.
