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
            $table->unsignedBigInteger('semester_id')->after('guru_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters');
        });

        Schema::table('presensi', function (Blueprint $table) {
            $table->unsignedBigInteger('semester_id')->after('siswa_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });

        Schema::table('presensi', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });
    }
};
