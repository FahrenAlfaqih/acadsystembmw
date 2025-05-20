# 📘 Sistem Akademik


Sistem Akademik adalah aplikasi Laravel untuk mengelola data keperluan akademik terkait Manajamen Guru, Siswa, Nilai, dan Presensi

---

## 🔍 Preview Tampilan
### User Autentikasi
![image](https://github.com/user-attachments/assets/9ef87a6e-664d-45e8-ad26-745b475165b4)
![image](https://github.com/user-attachments/assets/81c38f82-bdaf-461d-97e4-fcc113e9571d)

### User Role Tata Usaha
![image](https://github.com/user-attachments/assets/4158d47d-8abc-4e9d-ba99-02f64d647ad8)
![image](https://github.com/user-attachments/assets/df467e53-f8c4-46cf-a52b-20899f3e69f9)
![image](https://github.com/user-attachments/assets/ffd5ccda-b57e-4b7a-b7c0-e4b055430d74)



### User Role Guru
![image](https://github.com/user-attachments/assets/10ce176e-e58d-499d-9293-cc0ad9cfbbbd)
![image](https://github.com/user-attachments/assets/5dc3b624-9ed8-4446-ad6b-f80a2666edd3)



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
composer update
```

### 3. Salin file .env dan generate application key
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Konfigurasi koneksi database

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

