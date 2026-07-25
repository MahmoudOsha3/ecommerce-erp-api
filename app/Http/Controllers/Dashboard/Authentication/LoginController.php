<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authentication\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' ;
        $credentials = [
            $loginField => $request->login,
            'password'   => $request->password,
        ];
        if(! $token = auth('admin-api')->attempt($credentials)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $admin = auth('admin-api')->user();

        return response()->json([
            'success' => true,
            'message' => 'Admin Logged in Successfully',
            'data'    => [
                'admin' => $admin,
                'authorization' => $this->respondWithToken($token)
            ]
        ], 200);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin-api')->factory()->getTTL() * 120,
            'admin'    => auth('admin-api')->user()
        ];
    }
}
