<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='user_profiles';
    protected $fillable=[
        'name',
        'userid',
        'phone_number',
        'address',
        'image',
    ];

}
