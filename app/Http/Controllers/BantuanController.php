<?php

namespace App\Http\Controllers;

use App\bantuan;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\BantuanTransformer;

class BantuanController extends Controller
{
    protected $rules = [
        'id_pengajuan'      => 'required',
        'jumlah_dana'       => 'required'
    ];

    public function createBantuan(Request $request, bantuan $bantuan)
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
                $bantuan = $bantuan->create([
                    'id_pengajuan'        => $request->id_pengajuan,
                    'jumlah_dana'         => $request->jumlah_dana,
                ]);

                $response = fractal()
                    ->item($bantuan)
                    ->transformWith(new BantuanTransformer)
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
}
