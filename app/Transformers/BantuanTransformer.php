<?php

namespace App\Transformers;

use App\bantuan;
use League\Fractal\TransformerAbstract;

class BantuanTransformer extends  TransformerAbstract
{
    public function transform(bantuan $bantuan)
    {
        return [
            'id'               => $bantuan->id,
            'id_review'        => $bantuan->id_review,
            'jumlah_dana'      => $bantuan->jumlah_dana,
            'bukti'            => $bantuan->bukti,
            'dibuat'           => $bantuan->created_at->diffForHumans(),
        ];
    }
}