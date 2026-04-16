<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'kategori_id');
    }
}
