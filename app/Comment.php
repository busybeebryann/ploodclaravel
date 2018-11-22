<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'message'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the project that owns the comment.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
