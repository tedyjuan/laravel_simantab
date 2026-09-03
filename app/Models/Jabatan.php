<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'hr_ms_jabatan';

    protected $fillable = [
        'ulid',
        'kode_jabatan',
        'nama_jabatan',
        'jenis_jabatan',
        'urutan',
        'status',
    ];
}
