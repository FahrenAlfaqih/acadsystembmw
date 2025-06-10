<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('nilais', function (Blueprint $table) {
            // Menambahkan kolom untuk nilai ulangan harian, quiz, dan tugas
            $table->decimal('nilai_ulangan_harian', 5, 2)->nullable()->after('nilai_harian');
            $table->decimal('nilai_quiz', 5, 2)->nullable()->after('nilai_ulangan_harian');
            $table->decimal('nilai_tugas', 5, 2)->nullable()->after('nilai_quiz');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn(['nilai_ulangan_harian', 'nilai_quiz', 'nilai_tugas']);
        });
    }
};
