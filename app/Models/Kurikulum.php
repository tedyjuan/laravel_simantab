<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurikulum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acd_ms_kurikulum';

    protected $fillable = [
        'ulid',
        'kode_kurikulum',
        'nama_kurikulum',
        'deskripsi',
        'status',
    ];
}
