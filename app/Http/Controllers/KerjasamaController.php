<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\kerjasama;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\KerjasamaTransformer;

class KerjasamaController extends Controller
{
    protected $rules = [
        'id_pengajuan'      => 'required|integer',
        'id_perusahaan'      => 'required|integer',
        'produk'            => 'required|string',
        'jumlah'            => 'required|numeric',
    ];
    protected $rulesupdt = [
        'produk'            => 'required|string',
        'jumlah'            => 'required|numeric',
    ];

    public function createKerjasama(Request $request, kerjasama $kerjasama)
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
                $kerjasama = $kerjasama->create([
                    'id_pengajuan'   => $request->id_pengajuan,
                    'id_perusahaan'   => $request->id_perusahaan,
                    'produk'         => $request->produk,
                    'jumlah'         => $request->jumlah,
                ]);

                $response = fractal()
                    ->item($kerjasama)
                    ->transformWith(new KerjasamaTransformer)
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

    public function updateKerjasama(kerjasama $kerjasama,Request $request,$id)
    {
        if (!is_array($request->all()))
        {
            return ['error' => 'request harus berbentuk array'];
        }
        try
        {
            $validator = \Validator::make($request->all(), $this->rulesupdt);
            if($validator->fails())
            {
                return response()->json([
                    'updated' => false,
                    'errors'  => $validator->errors()->all()
                ], 500);
            }
            else
            {
              $kerjasama = kerjasama::find($id);
              $kerjasama->update([
                    'produk'      => $request->produk,
                    'jumlah'      => $request->jumlah,
              ]);

                $response = fractal()
                    ->item($kerjasama)
                    ->transformWith(new KerjasamaTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error updating kerjasama: ' .$e);
            return response()->json(['updated' => false], 500);
        }
    }

    public function showAll(kerjasama $kerjasama,$id)
    {
        $kerjasama = DB::table('kerjasamas')
                            ->join('pengajuans','kerjasamas.id_pengajuan','=','pengajuans.id')
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->join('perusahaans','perusahaans.id','=','kerjasamas.id_perusahaan')
                            ->select('anggotas.nama','anggotas.email','anggotas.kampus','anggotas.alamatKampus','kerjasamas.produk','kerjasamas.jumlah','kerjasamas.id')
                            ->where('id_perusahaan',$id)
                            ->get();
        return response()->json($kerjasama, 201);
    }

    public function showByIdAnggota(kerjasama $kerjasama, $id)
    {
        $kerjasama = DB::table('kerjasamas')
                            ->join('pengajuans','kerjasamas.id_pengajuan','=','pengajuans.id')
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->join('perusahaans','perusahaans.id','=','kerjasamas.id_perusahaan')
                            ->select('anggotas.nama','anggotas.email','anggotas.kampus','anggotas.alamatKampus', 'perusahaans.nama','perusahaans.alamat','perusahaans.email','kerjasamas.produk','kerjasamas.jumlah','pengajuans.proposal','pengajuans.event')
                            ->where('id_anggota',$id)
                            ->get();
        return response()->json($kerjasama,201);
    }
    
}
