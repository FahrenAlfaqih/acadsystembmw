# 📘 Sistem Akademik

Sistem Akademik adalah aplikasi Laravel untuk mengelola data guru, kelas, dan relasi antara keduanya.

---

## 📦 Persiapan Awal

Pastikan Anda sudah menginstall:

- PHP >= 8.0
- Composer
- MySQL
- Laravel (opsional: melalui Laravel installer atau via `composer`)
- Web server lokal seperti Laragon atau XAMPP

---

## ⚙️ Langkah Instalasi

### 1. Clone atau download project

```bash
cd C:\laragon\www
git clone https://github.com/username/sistem-akademik.git
cd sistem-akademik
```

### 2. Install semua dependensi Laravel
```bash
composer install
```

### 3. Salin file .env dan generate application key
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Konfigurasi koneksi database
copy .env.example .env
php artisan key:generate

## 🧱 Migrasi dan Seeder

### 5. Jalankan migrasi database
```bash
php artisan migrate
```

### 6.  Jalankan database seeder untuk mengisi data awal
```bash
php artisan db:seed
```

### 7. 🔗 Membuat Storage Link
```bash
php artisan storage:link
```

### 8. ▶️ Menjalankan Server Lokal
```bash
php artisan serve
```

