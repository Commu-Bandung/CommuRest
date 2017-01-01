<?php

namespace App\Transformers;

use App\pengajuan;
use League\Fractal\TransformerAbstract;

class ProposalTransformer extends  TransformerAbstract{
    function transform(pengajuan $pengajuan)
    {
        return [
            'id'            => $pengajuan->id,
            'id_anggota'    => $pengajuan->id_anggota,
            'proposal'      => $pengajuan->proposal,
            'event'         => $pengajuan->event,
            'kategori'      => $pengajuan->kategori,
            'deskripsi'     => $pengajuan->deskripsi,
            'status_valid'  => $pengajuan->status_valid,
            'status_rev'    => $pengajuan->status_rev,
            'published'     => $pengajuan->created_at->diffForHumans(),
        ];
    }
}
