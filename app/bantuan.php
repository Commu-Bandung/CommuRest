<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bantuan extends Model
{
    protected $fillable = [
        'id_pengajuan','jumlah_dana',
    ];

    

    public function pengajuan()
    {
        return $this->belongsTo(pengajuan::class);
    }
}
