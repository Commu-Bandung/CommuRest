<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kerjasama extends Model
{
    protected $fillable = [
        'id_pengajuan','produk','jumlah',
    ];

    

    public function pengajuan()
    {
        return $this->belongsTo(pengajuan::class);
    }
}
