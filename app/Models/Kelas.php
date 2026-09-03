<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'acd_ms_kelas';

    protected $fillable = [
        'ulid',
        'kode_kelas',
        'nama_kelas',
        'kode_jenjang',
        'tingkat',
        'status'
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'kode_jenjang', 'kode_jenjang');
    }
}
