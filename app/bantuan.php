<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bantuan extends Model
{
    protected $fillable = [
        'id_review','jumlah_dana','bukti',
    ];

    

    public function reviewproposal()
    {
        return $this->belongsTo(reviewproposal::class);
    }
}
