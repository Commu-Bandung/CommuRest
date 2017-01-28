<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kerjasama extends Model
{
    protected $fillable = [
        'id_review','produk','jumlah',
    ];

    

    public function reviewproposal()
    {
        return $this->belongsTo(reviewproposal::class);
    }
}
