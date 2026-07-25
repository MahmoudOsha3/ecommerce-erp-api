<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ResponseApi ;
    public function logout()
    {
        auth('admin-api')->logout();
        return $this->successApi(null , 'Admin logged out Seccessfully') ;
    }
}
