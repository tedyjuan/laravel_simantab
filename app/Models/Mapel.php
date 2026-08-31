<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'acd_ms_mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kkm',
        'kode_kurikulum',
        'kode_jenjang',
        'kelompok',
        'status',
    ];


    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kode_kurikulum', 'kode_kurikulum');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'kode_jenjang', 'kode_jenjang');
    }
}
