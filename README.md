# 📘 Sistem Akademik


Sistem Akademik adalah aplikasi Laravel untuk mengelola data keperluan akademik terkait Manajamen Guru, Siswa, Nilai, dan Presensi

---

## 🔍 Preview Tampilan
### User Role Tata Usaha
![image](https://github.com/user-attachments/assets/8676a7e4-6a7d-4577-85e2-c32cf436f634)
![image](https://github.com/user-attachments/assets/612d0d57-33a2-4b14-8950-9d9dee030374)
![image](https://github.com/user-attachments/assets/61b934ef-8a98-46e7-8c57-5f18084268b2)

### User Role Guru
![image](https://github.com/user-attachments/assets/ff6a558e-0026-4721-9549-710fbfe64c6e)
![image](https://github.com/user-attachments/assets/e670958e-f802-4c57-a87f-f17a0c21854f)
![image](https://github.com/user-attachments/assets/d34fcd9b-43c4-435d-a6fa-cdaacd10a1d1)

### User Role Siswa
![image](https://github.com/user-attachments/assets/4b323357-4cd2-4cf2-b1ec-8fb88576cf75)
![image](https://github.com/user-attachments/assets/082f0d72-d4c1-4f97-8d5c-13f0bc596170)
![image](https://github.com/user-attachments/assets/b027182b-d242-4185-8040-47bfbf162546)



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
DB_DATABASE=sistem_akademik
DB_USERNAME=root
DB_PASSWORD=


## 🧱 Migrasi dan Seeder

### 5. Jalankan migrasi database
```bash
php artisan migrate
```

### 6.  Jalankan database seeder untuk mengisi data awal
```bash
php artisan db:seed
```

### 7. Membuat Storage Link
```bash
php artisan storage:link
```

### 8. Menjalankan Server Lokal
```bash
php artisan serve
```

