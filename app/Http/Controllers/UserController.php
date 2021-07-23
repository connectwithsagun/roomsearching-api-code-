<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class UserController extends Controller
{
    function login(Request $request)
    {

//         $password = 'david';
// $hashedPassword = Hash::make($password);
// return response( $hashedPassword); 


        $user = User::where(['email' => $request->email, 'is_verified' => 1])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Your email is not verified yet,Please verify first..!']
            ], 404);
        }


       $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function otp()
    {
        $otp = rand(100000, 999999);
        return $otp;
    }

    public function register(Request $request)
    {
        $model = new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);
        $model->phone_number = $request->phone_number;
        $model->address = $request->address;
        $otp = $this->otp();
        $model->otp_code = $otp;
        if ($model->save()) {
            Mail::to($model->email)->send(new VerificationMail($model, $otp));
            return [
                'message' => "User Created, Please Check your email to verify your email..!",
                'user' => $model->email
            ];
        } else {
            return ['message' => "User not Created"];
        }
    }

    public function verifyOtp(Request $request)
    {
        $checkuser = User::where('otp_code', $request->otp_code)->where('email', $request->email);
        if ($checkuser->exists()) {
            $checkuser->update(['is_verified' => 1, 'email_verified_at' => date('Y-m-d h:m:s'), 'otp_code' => Null]);
            return ['message' => 'Verification Successfull'];
        } else {
            return ['message' => 'User not found'];
        }

    }

    public function registerUser(Request $request)
    {
        return User::all();
    }

    public function verifiedUser(Request $request)
    {
        return User::where(['is_verified'=>1])->get();
    }

    public function nonVerifiedUser(Request $request)
    {
        return User::where(['is_verified'=>0])->get();
    }

    public function userDetail($id)
    {
        return User::where(['id'=>$id])->get();
    }

    public function destroy($id){
        if(User::destroy($id)){
            return ['message'=>'User deleted Successfully'];
        }else{
            return ['message'=>'User Not Found'];
        }
    }
}
