<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOTP extends Model
{

    protected $table = 'user_otps';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'password',
        'used',
    ];

    protected $hidden = [
        'password'
    ];
}
