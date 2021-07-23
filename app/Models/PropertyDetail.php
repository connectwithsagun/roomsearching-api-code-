<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='property_details';
    protected $fillable=[
        'userid',
        'user_email',
        'property_image',
        'owner_name',
        'property_type',
        'property_location',
        'property_size',
        'property_rent',
        'available_from',
        'furniture_detail',
        'bathrooms',
        'bedrooms'
    ];

}
