<?php

namespace App\Traits;


trait ProjectFileTrait {


    public function scopeLatestFirst($query)
    {
        //code...
        return $query->orderBy('created_at','desc');
    }

    public function scopeOldestFirst($query)
    {
        //code...
        return $query->orderBy('created_at','asc');
    }

}