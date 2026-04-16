<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    public $timestamps = false;

    protected $fillable = [
        'petugas_id',
        'judul',
        'tipe',
        'periode_mulai',
        'periode_selesai',
        'file_path',
        'dicetak_at',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
