<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'npsn',
        'bentuk_pendidikan',
        'status',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kepala_sekolah',
        'operator',
        'username'
    ];
}
