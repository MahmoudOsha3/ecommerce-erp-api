<?php

namespace App\Http\Controllers\Dashboard\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authentication\ResetPasswordRequest;
use App\Models\Admin;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResponseApi ;
    public function reset(ResetPasswordRequest $request)
    {
        $request->validated() ;
        $reset = DB::table('password_reset_tokens')->where('email' , $request->email)->first() ;

        if (!$reset) {
            return $this->errorApi('Invalid OTP', 400);
        }

        if(Carbon::parse($reset->created_at)->addMinutes(10)->isPast())
        {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return $this->errorApi('Expired Token' , 400);
        }


        if (!Hash::check($request->otp, $reset->token)) {
            return $this->errorApi('Invalid OTP', 400);
        }

        Admin::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return $this->successApi(null, 'Password reset successfully');
    }
}
