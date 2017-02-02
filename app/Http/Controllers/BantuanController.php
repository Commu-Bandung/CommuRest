<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\bantuan;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\BantuanTransformer;

class BantuanController extends Controller
{
    protected $rules = [
        'id_review'         => 'required|integer',
        'jumlah_dana'       => 'required|numeric',
        'bukti'             => 'required',
    ];
    protected $rulesupdt = [
        'jumlah_dana'       => 'required',
        'bukti'             => 'required',
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
                ], 200);
            }
            else
            {
                $bantuan = $bantuan->create([
                    'id_review'           => $request->id_review,
                    'jumlah_dana'         => $request->jumlah_dana,
                    'bukti'               => $request->bukti,
                ]);

                $response = fractal()
                    ->item($bantuan)
                    ->transformWith(new BantuanTransformer)
                    ->toArray();

                return response()->json(['data' => $response, 'created' => true], 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error creating data : ' .$e);
            return response()->json(['created' => false], 500);
        }

    }

    public function updateBantuan(bantuan $bantuan, Request $request, $id)
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
              $bantuan = bantuan::find($id);
              $bantuan->update([
                    'jumlah_dana'      => $request->jumlah_dana,
                    'bukti'            => $request->bukti,
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
            \Log::info('Error updating dana: ' .$e);
            return response()->json(['updated' => false], 500);
        }
    }

    public function viewBantuan(bantuan $bantuan, $id)
    {
        $response = DB::table('bantuans')
                            ->join('reviewproposals','bantuans.id_review','=','reviewproposals.id')
                            ->join('pengajuans','reviewproposals.id_pengajuan','=','pengajuans.id')
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->join('perusahaans','perusahaans.id','=','reviewproposals.id_perusahaan')
                            ->select('perusahaans.nama','perusahaans.alamat','perusahaans.email','bantuans.jumlah_dana','bantuans.bukti','pengajuans.kategori','pengajuans.event')
                            ->where('id_anggota',$id)
                            ->orderBy('bantuans.created_at','desc')
                            ->get();
        return response()->json($response, 201);
    }

    public function showBantunaAll(bantuan $bantuan,$id)
    {
        $bantuan = DB::table('bantuans')
                            ->join('reviewproposals','bantuans.id_review','=','reviewproposals.id')        
                            ->join('pengajuans','reviewproposals.id_pengajuan','=','pengajuans.id')
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->join('perusahaans','perusahaans.id','=','reviewproposals.id_perusahaan')                            
                            ->select('anggotas.nama','anggotas.email','anggotas.kampus','anggotas.alamatKampus','bantuans.jumlah_dana','pengajuans.proposal','pengajuans.kategori','pengajuans.event', 'bantuans.bukti')
                            ->where('perusahaans.id',$id)
                            ->orderBy('bantuans.created_at','desc')                            
                            ->get();
        return response()->json($bantuan, 201);
    }
    public function showById(bantuan $bantuan, $id)
    {
        $bantuan = bantuan::find($id);

        return response()->json($bantuan, 201);
    }
}
