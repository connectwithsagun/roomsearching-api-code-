<?php

namespace App\Http\Controllers;

use http\Message;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\Fluent\Concerns\Has;
use Hash;

class ForgetPasswordController extends Controller
{
    //
    public function forgetpassword(Request $request)
    {
        $email=$request->email;
        $user=User::where('email',$email);
        if(!$user){
            return[
                'message'=>'Email not found'
            ];
        }
        $otp=$this->otp();
        $user->update(['otp_code'=>$otp]);
        $data=$user->first();
        Mail::to($data->email)->send(new ForgetPasswordMail($data,$otp));
        return [
            'message'=>'Email Sent, Please Check Your Otp Code To Reset Your Password..! '
        ];
    }
    public function resetpassword(Request $request){
        $checkuser=User::where('otp_code',$request->otp_code)->where('email',$request->email);

        if($checkuser->exists()){

            $checkuser->update(['is_verified'=>1,'email_verified_at'=>date('y-m-d h:m:s'),'otp_code'=>NULL,'password'=>Hash::make($request->password)]);
            return['message'=>'Password changed'];
        }
        else{
            return['message'=>'Error Changing Password '];
        }

    }


    public function otp(){
        $otp = rand(100000,999999);
        return $otp;
    }
    //testing for change password
    public function changepassword(Request $request){
        $checkuser=User::where('password',$request->password)->where('password',$request->password);

        if($checkuser->exists()){

            $checkuser->update(['is_verified'=>1,'email_verified_at'=>date('y-m-d h:m:s'),'otp_code'=>NULL,'password'=>Hash::make($request->password)]);
            return['message'=>'Password changed'];
        }
        else{
            return['message'=>'Error Changing Password...please check your credentials '];
        }

    }


}
