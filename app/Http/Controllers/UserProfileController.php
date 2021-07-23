<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;
use Response,File;

class UserProfileController extends Controller
{
    public function uploadFile(Request $request)
    {

        $validator = validator::make(request()->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'file' => 'required|image:jpg,png,gif,jpeg'
        ]);
        if ($validator->fails()) {
            return [
                'error' => $validator->errors(),
                'status' => false
            ];
        }
        if($file=$request->file('file')){
            $file= $request->file->store('public/documents');
            $model = new UserProfile();
            $model->userid = Auth::user()->id;
            $model->user_email = Auth::user()->email;
            $model->name = $request->name;
            $model->phone_number = $request->phone_number;
            $model->address = $request->address;
            $model->image = $file;
            $model->save();
            return ['succes' => true,
                'message' => 'User Details Updated Successfull',
                'path'=>Storage::disk('public')->url($file)
            ];
        }
    }

    public function userProfile(Request $request)
    {
        return UserProfile::all();
    }

    public function profileDetail($name)
    {
        return UserProfile::where(['name'=>$name])->get();
    }

    public function profileDetailId($id)
    {
        return UserProfile::where(['id'=>$id])->get();
    }

    public function username(Request $request){
        $results=UserProfile::where('name','like','%'.$request->searchquery.'%')->get();
        if(!empty($request)){
            return[
                'data'=>$results
            ];
        }else{
            return [
                'message'=>'No Data Found'
            ];
        }
    }


    public function destroy($id)
    {
        if (UserProfile::destroy($id)) {
            return ['message' => 'User deleted Successfully'];
        } else {
            return ['message' => 'User Not Found'];
        }
    }



}



