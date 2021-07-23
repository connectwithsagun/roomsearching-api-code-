<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyDetail;
use Illuminate\Support\Facades\Auth;
use Storage;

class PropertyDetailController extends Controller
{
    public function addproperty(Request $request)
    
    {
    //   return $request;
        if ($file = $request->file('file')) {
            $file = $request->file->store('public/documents');
            $model = new PropertyDetail();
            $model->userid = $request->uid;
            $model->user_email = $request->email;
            $model->owner_name = $request->name;
            $model->property_type = $request->property_type;
            $model->property_location = $request->location;
            $model->property_size = $request->size;
            $model->property_rent = $request->rent;
           $model->available_from = $request->date;
            $model->furniture_detail = $request->furniture;
            $model->bathrooms = $request->bathrooms;
            $model->bedrooms = $request->bedrooms;
            $model->property_image = $file;
            $model->save();
            return ['success' => true,
                'message' => 'Property added Successfull',
               'path' => Storage::disk('public')->url($file)
            ];
        }else{
            return ['success' => false,
            'message' => 'File not found in req',
        ];
        }
    }

    public function propertyDetail(Request $request)
    {
        return PropertyDetail::all();
    }

    public function Details($owner_name)
    {
        return PropertyDetail::where(['owner_name'=>$owner_name])->get();
    }

    public function destroy($id)
    {
        if (PropertyDetail::destroy($id)) {
            return ['message' => 'Property deleted Successfully'];
        } else {
            return ['message' => 'Property Not Found'];
        }
    }

   public function location(Request $request, $property_location)
    {
       return PropertyDetail::where(['property_location' => $property_location])->get() ;
    }

    public function search(Request $request)
    {
        $results = PropertyDetail::where('property_location', 'like', '%' . $request->searchquery . '%')
            ->orWhere('owner_name', 'like', '%' . $request->searchquery . '%')
            ->orWhere('property_type', 'like', '%' . $request->searchquery . '%')->get();
        if (!empty($request)) {
            return [
                'data' => $results
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No Data Found'
            ];
        }
    }

}
