<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authentication\LoginRequest;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ResponseApi ;

    public function login(LoginRequest $request)
    {
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' ;
        $credentials = [
            $loginField => $request->login,
            'password'   => $request->password,
        ];

        if(! $token = auth('admin-api')->attempt($credentials)){
            return $this->errorApi('Invalid credentials' , 401);
        }

        return $this->successApi($this->respondWithToken($token), 'Admin Logged in Successfully') ;
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
