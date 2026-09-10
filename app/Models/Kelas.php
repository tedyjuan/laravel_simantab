<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_kelas';

    protected $fillable = [
        'ulid',
        'kode_kelas',
        'nama_kelas',
        'kode_jenjang',
        'status'
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'kode_jenjang', 'kode_jenjang');
    }
}
