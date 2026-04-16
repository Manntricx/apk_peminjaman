<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';

    protected $fillable = [
        'kategori_id',
        'nama_alat',
        'deskripsi',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
