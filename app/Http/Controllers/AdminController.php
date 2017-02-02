<?php

namespace App\Http\Controllers;

use App\admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\AdminTransformer;
use Auth;

class AdminController extends Controller
{
    protected $rules = [
        'nama'      => 'required',
        'email'     => 'required|email|unique:admins',
        'password'  => 'required|min:6'

    ];
    protected $rulesupdt = [
        'nama'      => 'required',

    ];

    public function showAll(admin $admin)
    {
        $admins = $admin->all();

        $response = fractal()
            ->collection($admins)
            ->transformWith(new AdminTransformer)
            ->toArray();

        return response()->json($response, 201);
    }
    public function showById($id, admin $admin)
    {
        $admin = $admin->findorFail($id);
        return fractal()
            ->item($admin)
            ->transformWith(new AdminTransformer)
            ->toArray();
    }

    public function store(Request $request,admin $admin)
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
                $admin = $admin->create([
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'api_token' => bcrypt($request->email),
                    'password'  => bcrypt($request->password),
                ]);

                $response = fractal()
                    ->item($admin)
                    ->transformWith(new AdminTransformer)
                    ->toArray();

                return response()->json($response, 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error creating admin: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    public function updateAdmin(admin $admin, Request $request, $id)
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
                ], 200);
            }
            else
            {
              $admin = admin::find($id);
              $admin->update([
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'password'  => $request->password
              ]);

                $response = fractal()
                    ->item($admin)
                    ->transformWith(new AdminTransformer)
                    ->toArray();

                return response()->json(['data'=> $response, 'updated' => true], 201);
            }
        }
        catch (Exception $e)
        {
            \Log::info('Error updating admin: ' .$e);
            return response()->json(['created' => false], 500);
        }
    }

    public function deleteAdmin($id)
    {
        $admin = admin::findorFail($id);
        $admin->delete();

        return response()->json([
            'pesan' => 'admin sudah tiada'
        ]);
    }
}
