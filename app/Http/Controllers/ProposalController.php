<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\pengajuan;
use App\anggota;
use App\reviewproposal;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\ProposalTransformer;
use App\Transformers\ReviewTransformer;


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
        'id_pengajuan'    => 'required',
        'status'          => 'required', 
        'id_perusahaan'   => 'required',
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
                ], 200);
            }
            else
            {
                $pengajuan = $pengajuan->create([
                    'id_anggota'        => $request->id_anggota,
                    'proposal'          => $request->proposal,
                    'kategori'          => $request->kategori,
                    'deskripsi'         => $request->deskripsi,
                    'event'             => $request->event,
                    'status_valid'      => 'belum',
                ]);

                $response = fractal()
                    ->item($pengajuan)
                    ->transformWith(new ProposalTransformer)
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
    public function showPengajuanByUser(anggota $anggota,$id)
    {
        $response = DB::table('pengajuans')
                            ->join('reviewproposals','pengajuans.id','=','reviewproposals.id_pengajuan')
                            ->select('pengajuans.proposal','pengajuans.event','pengajuans.kategori','pengajuans.status_valid','reviewproposals.status')
                            ->where('id_anggota',$id)
                            ->orderBy('pengajuans.created_at','desc')
                            ->get();

        return response()->json($response, 201);        

    }

    public function showPengajuan(pengajuan $pengajuan)
    {      
         $response = pengajuan::where('status_valid','belum')
                                    ->orderBy('created_at','desc')                                    
                                    ->get();

        return response()->json($response, 201);
    }

    public function detailPengajuan($id, pengajuan $pengajuan)
    {
        $response = DB::table('pengajuans')
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->select('pengajuans.id','pengajuans.proposal','pengajuans.event','anggotas.kampus','anggotas.email','anggotas.alamatKampus')
                            ->where('pengajuans.id',$id)
                            ->get();
        
        return response()->json($response, 201);

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
                ], 200);
            }
            else
            {
                $pengajuan = pengajuan::find($id);
                $pengajuan = $pengajuan->update([
                    'status_valid'      => $request->status_valid,
                ]);

                $response = DB::table('pengajuans')
                                    ->where('id',$id)->get();

                return response()->json(['data' => $response, 'validasi' => true], 201);
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
         $response = pengajuan::where('status_valid','terima')
                                    ->orderBy('created_at','desc')
                                    ->get();

        return response()->json($response, 201);
    }

    public function reviewProposal(Request $request, reviewproposal $reviewproposal)
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
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ], 200);
            }
            else
            {
                $reviewproposal = $reviewproposal->create([
                    'id_pengajuan'      => $request->id_pengajuan,
                    'status'            => $request->status,
                    'id_perusahaan'     => $request->id_perusahaan,
                ]);

                $response = fractal()
                    ->item($reviewproposal)
                    ->transformWith(new ReviewTransformer)
                    ->toArray();

                return response()->json(['data' => $response, 'created' => true], 201);
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
        $response = DB::table('pengajuans')
                            ->join('reviewproposals','pengajuans.id','=','reviewproposals.id_pengajuan')
                            ->select('pengajuans.id','pengajuans.proposal','pengajuans.kategori','pengajuans.event',
                            'reviewproposals.status')
                            ->where([
                                'id_anggota'    => $id,
                                'status_valid'  => 'terima',
                                ]);
        $response = $response->whereIn('reviewproposals.status',['terima','tolak'])
                                ->orderBy('reviewproposals.created_at','desc')                                
                                ->get();

        return response()->json($response, 201);

    }

    public function showProposalDiterima($id)
    {
        $response = DB::table('pengajuans')
                            ->join('reviewproposals','pengajuans.id','=','reviewproposals.id_pengajuan')        
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->select('anggotas.nama','anggotas.email','anggotas.komunitas','anggotas.kampus','anggotas.alamatKampus',
                            'pengajuans.event','pengajuans.proposal','pengajuans.kategori','reviewproposals.id')
                            ->where([
                                'pengajuans.status_valid'       => 'terima',
                                'reviewproposals.status'        => 'terima',
                                'reviewproposals.id_perusahaan' => $id,
                            ])
                            ->orderBy('pengajuans.updated_at','desc')
                            ->get();

        return response()->json($response, 201);
    }
     public function showProposalDiterimaDetail($id)
    {
        $response = DB::table('pengajuans')
                            ->join('reviewproposals','pengajuans.id','=','reviewproposals.id_pengajuan')        
                            ->join('anggotas','pengajuans.id_anggota','=','anggotas.id')
                            ->select('anggotas.nama','anggotas.email','anggotas.komunitas','anggotas.kampus','anggotas.alamatKampus',
                            'pengajuans.event','pengajuans.proposal','pengajuans.kategori','reviewproposals.id')
                            ->where([
                                'pengajuans.status_valid'       => 'terima',
                                'reviewproposals.status'        => 'terima',
                                'reviewproposals.id'            => $id,
                            ])
                            ->orderBy('pengajuans.updated_at','desc')
                            ->get();

        return response()->json($response, 201);
    }
    public function seachEvent(Request $request, $event)
    {
        $hasilEvent = pengajuan::where('event','LIKE', '%' . $event . '%')->get();

        return response()->json($hasilEvent, 200);


    }
}
