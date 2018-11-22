<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'report_description',
    ];

    /**
     * Get the project that owns the project report.
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    /**
     * Get the user that owns the project report.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
