<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    use HasFactory;

    protected $table = 'acd_ms_jenjang';

    protected $fillable = [
        'kode_jenjang',
        'nama_jenjang',
        'urutan',
        'status'
    ];
}
