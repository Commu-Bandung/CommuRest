<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bantuan extends Model
{
    protected $fillable = [
        'id_pengajuan','id_perusahaan','jumlah_dana','bukti',
    ];

    

    public function pengajuan()
    {
        return $this->belongsTo(pengajuan::class);
    }
}
