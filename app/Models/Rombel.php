<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rombel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_rombel';

    protected $fillable = [
        'ulid',
        'kode_rombel',
        'nama_rombel',
        'kode_kelas',
        'kode_tahun_ajaran',
        'kode_pegawai',
        'kapasitas',
        'kode_ruangan',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'kode_tahun_ajaran', 'kode_tahun_ajaran');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kode_ruangan', 'kode_ruangan');
    }
}
