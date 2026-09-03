<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hr_ms_pegawai';

    protected $fillable = [
        'ulid',
        'kode_pegawai',
        'nip',
        'nama',
        'jenis_kelamin',
        'email',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'kode_jabatan',
        'tanggal_masuk',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date'
    ];
}
