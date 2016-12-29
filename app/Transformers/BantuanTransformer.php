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
            'id_pengajuan'     => $bantuan->id_pengajuan,
            'jumlah_dana'      => $bantuan->jumlah_dana,
            'dibuat'       => $bantuan->created_at->diffForHumans(),
        ];
    }
}