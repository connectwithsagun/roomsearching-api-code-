<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\PropertyAminiti;
use Illuminate\Support\Facades\Auth;

class PropetyAminitiController extends Controller
{
    public function addAminites(Request $request){
        $model = new PropertyAminiti();

        $model->userid = Auth::user()->id;
        $model->user_email = Auth::user()->email;
        $model->restroom = $request->restroom;
        $model->freewifi = $request->freewifi;
        $model->kitchen = $request->kitchen;
        $model->tv = $request->tv;
        $model->loundary = $request->loundary;
        $model->cctv = $request->cctv;
        $model->parking = $request->parking;
        $model->security_guide = $request->security_guide;
        if ($model->save()) {
            return [ 'message'=>'data save'];
        }
    }
    public function showAminiti(Request $request){
        return PropertyAminiti::all();
    }

    public function destroy($id)
    {
        if (PropertyAminiti::destroy($id)) {
            return ['message' => 'Property  Aminities Deleted Successfully'];
        } else {
            return ['message' => 'Property Aminities Not Found'];
        }
    }
}
