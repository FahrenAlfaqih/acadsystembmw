<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Autentikasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan selama proses autentikasi untuk berbagai
    | pesan yang perlu ditampilkan kepada pengguna. Anda bebas untuk
    | mengubah pesan-pesan ini sesuai dengan kebutuhan aplikasi Anda.
    |
    */

    'failed' => 'Data yang Anda masukkan tidak cocok dengan data kami.',
    'password' => 'Kata sandi yang Anda masukkan salah.',
    'throttle' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam :seconds detik.',

    /*
    |--------------------------------------------------------------------------
    | Pesan Tambahan (opsional)
    |--------------------------------------------------------------------------
    */

    'login' => [
        'success' => 'Berhasil masuk.',
        'logout' => 'Anda telah berhasil keluar.',
    ],

    'register' => [
        'success' => 'Pendaftaran berhasil. Silakan masuk.',
    ],

    'verification' => [
        'sent' => 'Tautan verifikasi telah dikirim ke email Anda.',
        'verified' => 'Email Anda telah berhasil diverifikasi.',
        'already_verified' => 'Email Anda sudah diverifikasi.',
        'invalid' => 'Tautan verifikasi tidak valid atau telah kedaluwarsa.',
    ],

    'reset' => [
        'sent' => 'Kami telah mengirimkan tautan reset kata sandi ke email Anda.',
        'success' => 'Kata sandi Anda telah berhasil direset.',
        'invalid' => 'Token reset tidak valid.',
        'throttled' => 'Silakan tunggu sebelum mencoba lagi.',
    ],

];
