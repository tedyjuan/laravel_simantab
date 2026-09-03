<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenjang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_jenjang';

    protected $fillable = [
        'ulid',
        'kode_jenjang',
        'nama_jenjang',
        'urutan',
        'status'
    ];
}
