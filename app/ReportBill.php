<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportBill extends Model
{

     /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'fc_report_bills';

     protected $fillable = [
         'fc_hearing_id',
         'title',
         'short_title',
         'bill_number',
         'issue_support',
         'issue_against',
         'recommendations',
         'action_taken',
    ];
      /**
     * Get the hering report that owns the report bill.
     */
    public function fc_hearing_report() {
        return $this->belongsTo('App\HearingReport','fc_hearing_id');
    }
}
