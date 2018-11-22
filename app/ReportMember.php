<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportMember extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'fc_report_members';

     protected $fillable = [
         'fc_hearing_id',
         'name',
         'district',
    ];

    /**
     * Get the hering report that owns the members.
     */
     public function fc_hearing_report() {
        return $this->belongsTo('App\HearingReport','fc_hearing_id');
    }
}
