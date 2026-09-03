<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_ms_ruangan';

    protected $fillable = [
        'ulid',
        'kode_ruangan',
        'nama_ruangan',
        'kode_gedung',
        'lantai',
        'kapasitas',
        'jenis',
        'deskripsi',
        'status',
    ];
    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'kode_gedung', 'kode_gedung');
    }
}
