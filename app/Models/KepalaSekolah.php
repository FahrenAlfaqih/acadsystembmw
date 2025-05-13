<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    use HasFactory;

    protected $table = 'kepala_sekolah';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'email',
        'status',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
