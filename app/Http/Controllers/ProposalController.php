<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\pengajuan;
use App\anggota;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\ProposalTransformer;


class ProposalController extends Controller
{
    protected $rules = [
        'id_anggota'        => 'required',
        'proposal'          => 'required',
        'event'             => 'required',
        'kategori'          => 'required',
        'deskripsi'         => 'required'
    ];
    protected $validasi = [
        'status_valid'      => 'required', 
    ];
    protected $review = [
        'status_rev'      => 'required', 
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
                    'event'             => $request->event,
                    'kategori'          => $request->kategori,
                    'deskripsi'         => $request->deskripsi,
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
    public function showPengajuanByUser(anggota $anggota,$id)
    {
        $response = DB::table('pengajuans')
                            ->where('id_anggota',$id)->get();

        return response()->json($response, 201);        

    }

    public function showPengajuan(pengajuan $pengajuan)
    {      
         $response = pengajuan::where('status_valid','belum')->get();

        return response()->json($response, 201);
    }

    public function detailPengajuan($id, pengajuan $pengajuan)
    {
        $pengajuan = $pengajuan->findOrFail($id);
        return fractal()
            ->item($pengajuan)
            ->transformWith(new ProposalTransformer)
            ->toArray();
    }


    public function validasiPersyaratan(Request $request, $id, pengajuan $pengajuan)
    {
           if (!is_array($request->all()))
        {
            return ['error' => 'request harus berbentuk array'];
        }
        try
        {
            $validator = \Validator::make($request->all(), $this->validasi);
            if($validator->fails())
            {
                return response()->json([
                    'validasi' => false,
                    'errors'  => $validator->errors()->all()
                ], 500);
            }
            else
            {
                $pengajuan = pengajuan::find($id);
                $pengajuan = $pengajuan->update([
                    'status_valid'      => $request->status_valid,
                    'status_rev'        => 'belum',

                ]);

                $response = DB::table('pengajuans')
                                    ->where('id',$id)->get();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error validating  : ' .$e);
            return response()->json(['created' => false], 500);
        }             
    }
    public function showPengajuanValid(pengajuan $pengajuan)
    {      
         $response = pengajuan::where('status_valid','terima')->get();

        return response()->json($response, 201);
    }

    public function reviewProposal(Request $request, $id, pengajuan $pengajuan)
    {
        if (!is_array($request->all()))
        {
            return ['error' => 'request harus berbentuk array'];
        }
        try
        {
            $validator = \Validator::make($request->all(), $this->review);
            if($validator->fails())
            {
                return response()->json([
                    'validasi' => false,
                    'errors'  => $validator->errors()->all()
                ], 500);
            }
            else
            {
                $pengajuan = pengajuan::find($id);
                $pengajuan = $pengajuan->update([
                    'status_rev'        => $request->status_rev,

                ]);

                $response = DB::table('pengajuans')
                                    ->where('id',$id)->get();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error reviewing  : ' .$e);
            return response()->json(['created' => false], 500);
        }   

    }

    public function viewHasilReview($id)
    {
        $response = pengajuan::where([
            'id_anggota'    => $id,
            'status_valid'  => 'terima',
        ]);
        $response = $response->whereIn('status_rev',['terima','tolak'])->get();

        return response()->json($response, 201);

    }

    public function showProposalDiterima()
    {
        $response = DB::table('pengajuans')
                            ->where([
                                'status_valid'      => 'terima',
                                'status_rev'        => 'terima',
                            ])->get();

        return response()->json($response, 201);
    }
    public function seachEvent(Request $request, $event)
    {
        $hasilEvent = pengajuan::where('event','LIKE', '%' . $event . '%')->get();

        return response()->json($hasilEvent, 200);


    }
}
