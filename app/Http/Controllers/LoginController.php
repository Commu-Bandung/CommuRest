<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\admin;
use App\anggota;
use App\perusahaan;
use App\Transformers\AdminTransformer;
use App\Transformers\AnggotaTransformer;
use App\Transformers\PerusahaanTransformer;
use Auth;

class LoginController extends Controller
{
    protected $rules = [
        'email'     => 'required|email',
        'password'  => 'required'
    ];
    public function __invoke(Request $request)
    {       
        $email_in        = $request->email;
        $password_in     = $request->password;        

         $loginAnggota = DB::table('anggotas')
                            ->where([
                                ['email',   '=',$email_in],
                                ['password','=',$password_in],
                            ])->count();
        $loginAdmin = DB::table('admins')
                            ->where([
                                ['email',   '=',$email_in],
                                ['password','=',$password_in],
                            ])->count();   
        $loginPerusahaan = DB::table('perusahaans')
                            ->where([
                                ['email',   '=',$email_in],
                                ['password','=',$password_in],
                            ])->count();

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
                    'login' => false,
                    'errors'  => $validator->errors()->all()
                ], 500);
            }
            else if($loginAdmin > 0)
            {
              
                $response = DB::table('admins')
                                    ->where([
                                        ['email',   '=',$email_in],
                                        ['password','=',$password_in],
                                    ])->get(); 


                return response()->json($response, 201);
            }
            else if($loginAnggota > 0)
            {
              
                $response = DB::table('anggotas')
                                    ->where([
                                        ['email',   '=',$email_in],
                                        ['password','=',$password_in],
                                    ])->get(); 


                return response()->json($response, 201);
            }
            else if($loginPerusahaan > 0)
            {
              
                $response = DB::table('perusahaans')
                                    ->where([
                                        ['email',   '=',$email_in],
                                        ['password','=',$password_in],
                                    ])->get(); 


                return response()->json($response, 201);
            }
            else
            {
                return response()->json([
                    'login' => 'email or password is wrong'
                ], 404);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error login  : ' .$e);
            return response()->json(['login' => false], 500);
        }   

    }


}
