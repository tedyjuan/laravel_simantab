<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tingkatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_tingkatan';

    protected $fillable = [
        'ulid',
        'kode_tingkatan',
        'kode_jenjang',
        'nama_tingkatan',
        'urutan',
        'status',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'kode_jenjang', 'kode_jenjang');
    }
}
