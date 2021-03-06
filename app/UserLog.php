<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activity',
    ];

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
