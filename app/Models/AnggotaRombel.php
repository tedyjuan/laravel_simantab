<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaRombel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_trx_anggota_rombel';

    protected $fillable = [
        'ulid',
        'nis',
        'kode_rombel',
        'kode_tahun_ajaran',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'kode_rombel', 'kode_rombel');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'kode_tahun_ajaran', 'kode_tahun_ajaran');
    }
}
