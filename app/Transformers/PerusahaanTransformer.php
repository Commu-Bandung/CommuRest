<?php

namespace App\Transformers;

use App\perusahaan;
use League\Fractal\TransformerAbstract;

class PerusahaanTransformer extends TransformerAbstract
{
    public function transform(perusahaan $perusahaan)
    {
        return [
            'id'        => $perusahaan->id,
            'nama'      => $perusahaan->nama,
            'alamat'    => $perusahaan->alamat,
            'email'     => $perusahaan->email,
            'api_token' => $perusahaan->api_token,
            'deskrisi'  => $perusahaan->deskripsi,
            'registered'=> $perusahaan->created_at->diffForHumans(),
        ];
    }
}