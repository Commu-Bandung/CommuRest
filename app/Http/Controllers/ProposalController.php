<?php

namespace App\Http\Controllers;

use App\pengajuan;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\ProposalTransformer;


class ProposalController extends Controller
{
    protected $rules = [
        'id_anggota'        => 'required',
        'proposal'          => 'required',
    ];
    protected $validasi = [
        'status_valid'      => 'required', 
    ];
    public function ajukan(Request $request, pengajuan $pengajuan)
    {
        if (!is_array($request->all()))
        {
            return ['error' => 'request harus berbentuk array'];
        }
        try
        {
            $validator = \Validator::make($request->all(), $this->rules);
            if($validator->fails())
            {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ], 500);
            }
            else
            {
                $pengajuan = $pengajuan->create([
                    'id_anggota'        => $request->id_anggota,
                    'proposal'          => $request->proposal,
                    'status_valid'      => 'belum',
                    'status_rev'        => 'belum',
                ]);

                $response = fractal()
                    ->item($pengajuan)
                    ->transformWith(new ProposalTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
            }
        catch (Exception $e)
        {
            \Log::info('Error creating data : ' .$e);
            return response()->json(['created' => false], 500);
        }

    }


    public function validasiPersyaratan(Request $request)
    {
        
    }
}
