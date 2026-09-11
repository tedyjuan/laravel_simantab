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
        'kode_tahun_ajaran_header', // <- diganti
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
        // FK & kolom tujuan sama-sama kode_tahun_ajaran_header
        return $this->belongsTo(TahunAjar::class, 'kode_tahun_ajaran_header', 'kode_tahun_ajaran_header');
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
