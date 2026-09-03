<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_tahun_ajaran';

    protected $fillable = [
        'ulid',
        'kode_tahun_ajaran',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'semester',
        'status',
        'created_at',
        'updated_at'
    ];
}
