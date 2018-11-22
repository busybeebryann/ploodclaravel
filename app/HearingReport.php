<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HearingReport extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fc_hearing_reports';

    protected $fillable = [
        'committee_name',
        'report_date',
    ];

    public function fc_report_members()
    {
        return $this->hasMany('App\ReportMember');
    }


    public function fc_report_resource_persons()
    {
        return $this->hasMany('App\ReportResourcePerson');
    }


    public function fc_report_bills(){
        return $this->hasMany('App\ReportBill');
    }

 
    

}
