<?php

namespace App\Transformers;

use App\pengajuan;
use League\Fractal\TransformerAbstract;

class PengajuanTransformer extends  TransformerAbstract{
    function transform(pengajuan $pengajuan)
    {
        return [
            'id'            => $pengajuan->id,
            'proposal'      => $pengajuan->proposal,
            'status_valid'  => $pengajuan->status_valid,
            'status_rev'    => $pengajuan->status_rev,
            'published'     => $pengajuan->created_at->diffForHumans(),
        ];
    }
}
