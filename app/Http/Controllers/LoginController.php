<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\admin;
use App\anggota;
use App\Transformers\AdminTransformer;
use App\Transformers\AnggotaTransformer;
use Auth;

class LoginController extends Controller
{
    public function loginAnggota(Request $request, anggota $anggota)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Your credential is wrong'], 401);
        }

        $anggota = $anggota->find(Auth::anggota()->id);

        return fractal()
            ->item($anggota)
            ->transformWith(new AnggotaTransformer)
            ->toArray();


    }
}
