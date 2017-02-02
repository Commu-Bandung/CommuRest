<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\anggota;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\COntroller;
use App\Transformers\AnggotaTransformer;
use Auth;

class RegistrasiController extends Controller
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
    public function register(Request $request, anggota $anggota)
    {
        $email_in = $request->email;

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
                $anggota = $anggota->create([
                    'nama'              => $request->nama,
                    'email'             => $request->email,
                    'password'          => $request->password,
                    'remember_token'    => bcrypt($request->email),
                    'komunitas'         => $request->komunitas,
                    'kampus'            => $request->kampus,
                    'alamatKampus'      => $request->alamatKampus,
                    'deskripsi'         => $request->deskripsi,
                ]);

               
                $response = DB::table('anggotas')
                                    ->where([
                                        ['email',   '=',$email_in],
                                    ])->get(); 

                return response()->json(['data' => $response, 'created' => true ], 201);
            }
            }
        catch (Exception $e)
        {
            \Log::info('Error register data anggota: ' .$e);
            return response()->json(['created' => false], 500);
        }
        
    }
}
