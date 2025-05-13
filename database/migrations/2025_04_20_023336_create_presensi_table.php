<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit', 'Alpha']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
