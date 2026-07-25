<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authentication\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\Admin ;
use App\Traits\ResponseApi;

class RegisterController extends Controller
{
    use ResponseApi ;

    public function register(RegisterRequest $request)
    {
        $admin = Admin::create($request->validated()) ;
        $token = auth('admin-api')->login($admin);
        return $this->successApi($this->respondWithToken($token) ,'Admin registered successfully' , 201);
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
