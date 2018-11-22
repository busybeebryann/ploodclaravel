<?php

namespace App;

use App\Traits\ProjectFileTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    use ProjectFileTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'file_name',
        'file_path',
        'encrypted_file_path',
    ];

    public function projects(){
        return $this->belongsToMany('App\Project', 'project_files', 'file_name', 'file_path')->latestFirst();
    }
}
