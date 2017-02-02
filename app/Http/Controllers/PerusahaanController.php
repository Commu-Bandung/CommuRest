<?php

namespace App\Http\Controllers;

use App\perusahaan;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\PerusahaanTransformer;
use Auth;

class PerusahaanController extends Controller
{
    protected $rules = [
        'nama'      => 'required',
        'alamat'    => 'required|min:15',
        'email'     => 'required|email:perusahaans',
        'password'  => 'required|min:6',
        'deskripsi' => 'required|min:10'

    ];
    protected $rulesupdt = [
        'nama'      => 'required',
        'alamat'    => 'required|min:15',
        'email'     => 'required|email:perusahaans',
        'deskripsi' => 'required|min:10'

    ];
    public function showAll(perusahaan $perusahaan)
    {
        $perusahaans = $perusahaan->all();

        $response = fractal()
            ->collection($perusahaans)
            ->transformWith(new PerusahaanTransformer)
            ->toArray();

        return response()->json($response, 201);
        
    }

    public function add(Request $request, perusahaan $perusahaan)
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
                $perusahaan = $perusahaan->create([
                    'nama'          => $request->nama,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'api_token'     => bcrypt($request->email),
                    'password'      => $request->password,
                    'deskripsi'     => $request->deskripsi,
                ]);

                $response = fractal()
                    ->item($perusahaan)
                    ->transformWith(new PerusahaanTransformer)
                    ->toArray();

                return response()->json(['data' => $response,'created' => true], 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error creating data perusahaan: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    
    public function profileId($id, perusahaan $perusahaan)
    {
        $perusahaan = $perusahaan->findorFail($id);
        return fractal()
            ->item($perusahaan)
            ->transformWith(new PerusahaanTransformer)
            ->toArray();       
    }

    
    public function updatePerusahaan(Request $request, $id, perusahaan $perusahaan)
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
              $perusahaan = perusahaan::find($id);
              $perusahaan->update([
                    'nama'          => $request->nama,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'deskripsi'     => $request->deskripsi,
                ]);

                $response = fractal()
                    ->item($perusahaan)
                    ->transformWith(new PerusahaanTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error updating data perusahaan: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    
    public function deletePerusahaan($id)
    {
        $perusahaan = perusahaan::findorFail($id);
        $perusahaan->delete();

        return response()->json([
            'pesan' => 'perusahaan sudah bangkrut/mengundurkan diri entahlah'
        ]);
    }
    public function searchPerusahaan(Request $request, $perusahaan)
    {
        $pencarian = perusahaan::where('nama','LIKE','%' . $perusahaan . '%')
                                    ->get();

        return response()->json($pencarian, 200);
    }
}
