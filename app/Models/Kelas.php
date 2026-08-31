<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'tingkat',
        'jurusan',
        'rombel',
        'id_tahun_ajaran',
        'id_wali_kelas',
        'kapasitas',
        'ruangan',
        'status',
    ];

    protected $casts = [
        'tingkat'   => 'integer',
        'kapasitas' => 'integer',
    ];

    // Relasi ke Tahun Ajaran (wajib ada, restrictOnDelete)
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjar::class, 'id_tahun_ajaran');
    }

    // Relasi ke Wali Kelas / Pegawai (opsional, nullOnDelete)
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_wali_kelas');
    }
}
