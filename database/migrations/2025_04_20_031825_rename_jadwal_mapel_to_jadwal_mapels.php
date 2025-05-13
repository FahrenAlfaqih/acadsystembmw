<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('jadwal_mapel', 'jadwal_mapels');
    }

    public function down(): void
    {
        Schema::rename('jadwal_mapels', 'jadwal_mapel');
    }
};
