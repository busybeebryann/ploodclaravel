<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'report_name',
        'report_path',
        'encrypted_file_path',
    ];

    public function projects(){
        return $this->belongsToMany('App\Project', 'project_files', 'report_name', 'report_path');
    }
}
