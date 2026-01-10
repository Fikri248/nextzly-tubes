<p align="center">
  <img src="https://raw.githubusercontent.com/Fikri248/nextzly-tubes/main/public/brand.png" alt="nexTizen Logo" width="250">
</p>

# Nextzly


Platform penjualan produk digital premium berbasis web. Dibangun dengan Laravel 10 dan Tailwind CSS.

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 10, PHP 8.1+ |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL |
| Export | DomPDF, Maatwebsite Excel |

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7

## Installation

```bash
# Clone repository
git clone https://github.com/Fikri248/nextzly-tubes.git
cd nextzly-tubes

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
# DB_DATABASE=nextzly
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Build assets
npm run build

# Start server
php artisan serve
```

## Features

### Public
- Landing page dengan katalog produk
- Detail produk dan checkout
- Pembayaran via QRIS
- Riwayat transaksi pelanggan

### Admin Panel
- **Dashboard** — Statistik penjualan dan grafik
- **Kategori** — CRUD kategori produk
- **Produk** — CRUD produk dengan upload logo
- **Pelanggan** — Daftar dan riwayat transaksi per pelanggan
- **Transaksi** — Filter, search, update status, auto stok management
- **Laporan** — Query dan export laporan penjualan (PDF/Excel)
