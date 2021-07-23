<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAminiti extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='property_aminites';
    protected $fillable=[
        'userid',
        'user_email',
        'restroom',
        'freewifi',
        'kitchen',
        'tv',
        'loundary',
        'cctv',
        'parking',
        'security_guide'
        ];
}
