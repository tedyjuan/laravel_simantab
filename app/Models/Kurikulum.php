<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'acd_ms_kurikulum';

    protected $fillable = [
        'kode_kurikulum',
        'nama_kurikulum',
        'deskripsi',
        'status',
    ];
}
