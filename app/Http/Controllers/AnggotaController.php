<?php

namespace App\Http\Controllers;

use App\anggota;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\AnggotaTransformer;
use Auth;

class AnggotaController extends Controller
{
    protected $rules = [
        'nama'          => 'required',
        'email'         => 'required|email|unique:anggotas',
        'password'      => 'required|min:6',
        'komunitas'     => 'required',
        'kampus'        => 'required',
        'alamatKampus'  => 'required|min:15',
        'deskripsi'     => 'required'

    ];
    protected $rulesupdt = [
        'nama'          => 'required',
        'komunitas'     => 'required',
        'kampus'        => 'required',
        'alamatKampus'  => 'required|min:15',
        'deskripsi'     => 'required'

    ];
    
    public function addAnggota(Request $request, anggota $anggota)
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
                $anggota = $anggota->create([
                    'nama'          => $request->nama,
                    'email'         => $request->email,
                    'password'      => $request->password,
                    'api_token'     => bcrypt($request->email),
                    'komunitas'     => $request->komunitas,
                    'kampus'        => $request->kampus,
                    'alamatKampus'  => $request->alamatKampus,
                    'deskripsi'     => $request->deskripsi,
                ]);

                $response = fractal()
                    ->item($anggota)
                    ->transformWith(new AnggotaTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
            }
        catch (Exception $e)
        {
            \Log::info('Error creating data anggota: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    public function updateAnggota(Request $request, $id, anggota $anggota)
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
              $anggota = anggota::find($id);
              $anggota->update([
                    'nama'          => $request->nama,
                    'komunitas'     => $request->komunitas,
                    'kampus'        => $request->kampus,
                    'alamatKampus'  => $request->alamatKampus,
                    'deskripsi'     => $request->deskripsi,
                ]);

                $response = fractal()
                    ->item($anggota)
                    ->transformWith(new AnggotaTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error updating data anggota: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    public function deleteAnggota($id)
    {
        $anggota = anggota::findorFail($id);
        $anggota->delete();

        return response()->json([
            'pesan' => 'anggota sudah tiada'
        ]);
    }
    public function showAll(anggota $anggota)
    {
        $anggotas = $anggota->all();

        $response = fractal()
            ->collection($anggotas)
            ->transformWith(new AnggotaTransformer)
            ->toArray();

        return response()->json($response, 201);
        
    }
    public function profileId($id, anggota $anggota)
    {
        $anggota = $anggota->findorFail($id);
        return fractal()
            ->item($anggota)
            ->transformWith(new AnggotaTransformer)
            ->toArray();       
    }
}
