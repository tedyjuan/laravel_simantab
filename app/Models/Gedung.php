<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'inv_ms_gedung';

    protected $fillable = [
        'ulid',
        'kode_gedung',
        'nama_gedung',
        'alamat',
        'jumlah_lantai',
        'deskripsi',
        'status',
    ];
}
