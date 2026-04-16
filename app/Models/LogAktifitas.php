<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktifitas extends Model
{
    protected $table = 'log_aktifitas';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'aksi',
        'keterangan',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
