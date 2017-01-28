<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pengajuan;

class reviewproposal extends Model
{
    protected $fillable = [
        'id_pengajuan','status','id_perusahaan',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(pengajuan::class);
    }
}
