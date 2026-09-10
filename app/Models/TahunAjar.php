<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_tahun_ajaran_header';

    protected $fillable = [
        'ulid',
        'kode_tahun_ajaran_header',
        'nama_tahun_ajaran_header',
        'tahun_mulai',
        'tahun_selesai',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(
            TahunAjarDetail::class,
            'kode_tahun_ajaran_header',
            'kode_tahun_ajaran_header'
        );
    }
}
