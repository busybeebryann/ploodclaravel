<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportResourcePerson extends Model
{
    //

     /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'fc_report_resource_persons';
     
          protected $fillable = [
              'fc_hearing_id',
              'name',
              'agency',
         ];
           /**
          * Get the hering report that owns the resouce person.
          */
         public function fc_hearing_report() {
             return $this->belongsTo('App\HearingReport','fc_hearing_id');
         }
}
