<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\anggota;

class pengajuan extends Model
{
    protected $fillable = [
        'id_anggota','proposal','kategori','deskripsi','event', 'status_valid','status_rev',
    ];

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('id','DESC');
    }

    public function anggota()
    {
        return $this->belongsTo(anggota::class);
    }
}
