<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjarDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_tahun_ajaran_detail';

    protected $fillable = [
        'ulid',
        'kode_tahun_ajaran_detail',
        'kode_tahun_ajaran_header',
        'nama_tahun_ajaran_detail',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
