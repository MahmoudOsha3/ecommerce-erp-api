<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authentication\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\Admin ;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $admin = Admin::create($request->validated()) ;

        $token = auth('admin-api')->login($admin);

        return response()->json([
            'success' => true,
            'message' => 'Admin registered successfully',
            'data'    => $admin,
            'authorization' => [
                'token'      => $token,
                'type'       => 'bearer',
                'expires_in' => auth('admin-api')->factory()->getTTL() * 60
            ]
        ], 201);
    }
}
