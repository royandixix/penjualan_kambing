# 🚀 Kamberu - Sistem Penjualan Kambing (Laravel + Ngrok + QR + WhatsApp)

Sistem penjualan kambing berbasis **Laravel** dengan fitur:
- Login & Registrasi User (Admin / Pembeli)
- QR Code otomatis untuk login
- Integrasi **Ngrok** agar bisa diakses dari HP / device luar
- Kirim **link QR Code ke WhatsApp** user via API Fonnte

---

## 📦 Persiapan

### 1. Clone Project & Install Dependensi
```bash
git clone https://github.com/username/penjualan_kambing.git
cd penjualan_kambing
composer install
npm install && npm run build


APP_NAME=Kamberu
APP_ENV=local
APP_KEY=base64:xxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penjualan_kambing
DB_USERNAME=root
DB_PASSWORD=

# Token Fonnte (WA Gateway)
FONNTE_TOKEN=ISI_DENGAN_TOKEN_FONNTE



php artisan key:generate
php artisan migrate --seed

php artisan serve

ngrok http 8000

Forwarding https://26b802054d41.ngrok-free.app -> http://localhost:8000
 


 Halo Budi,

Selamat! Kamu berhasil mendaftar di sistem Kamberu.

Untuk login, klik link QR Code berikut:
https://xxxx.ngrok-free.app/storage/qr/5.png
# penjualan_kambing
