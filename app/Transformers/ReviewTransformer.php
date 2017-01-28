<?php
namespace App\Transformers;

use App\reviewproposal;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
    public function transform(reviewproposal $review)
    {
        return [
            'id'            => $review->id,
            'id_pengajuan'  => $review->id_pengajuan,
            'status'        => $review->status,
            'id_perusahaan' => $review->id_perusahaan,
        ];
    }
}