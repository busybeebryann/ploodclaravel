<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile_number',
        'birthdate',
        'address',
        'gender',
        'user_level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the comments for the project.
     */
    public function comments()
    {
        return $this->hasMany('Comment');
    }

    /**
     * Get the user log.
     */
    public function user_logs()
    {
        return $this->hasMany('UserLog');
    }

    /**
     * Get the projects that belongs to many users.
     */
    public function projects(){
        return $this->belongsToMany('App\Project', 'collaborators', 'user_id', 'project_id');
    }

    /**
     * Get the comments for the project.
     */
    public function project_reports()
    {
        return $this->hasMany('ProjectReport');
    }

    /**
     * Concat the full name in the result set involbing the user.
     */
    public function getFullNameAttribute(){
        return ucfirst($this->first_name . " " .$this->last_name);
    }


}
