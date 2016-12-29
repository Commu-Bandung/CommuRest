<?php

namespace App\Transformers;

use App\kerjasama;
use League\Fractal\TransformerAbstract;

class KerjasamaTransformer extends  TransformerAbstract
{
    public function transform(kerjasama $kerjasama)
    {
        return [
            'id'               => $kerjasama->id,
            'id_pengajuan'     => $kerjasama->id_pengajuan,
            'produk'           => $kerjasama->produk,
            'jumlah'           => $kerjasama->jumlah,
            'dibuat'           => $kerjasama->created_at->diffForHumans(),
        ];
    }
}