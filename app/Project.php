<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the comments for the project.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function users(){
    	return $this->belongsToMany('App\User', 'collaborators', 'project_id', 'user_id');
    }
    
    /**
     * Get the project files for the project.
     */
    public function project_file(){
        return $this->hasMany('App\ProjectFile');
    }

    /**
     * Get the comments for the project.
     */
    public function project_reports()
    {
        return $this->hasMany('App\ProjectReport');
    }

    public function report_files()
    {
        return $this->hasMany('App\ReportFile');
    }
}
