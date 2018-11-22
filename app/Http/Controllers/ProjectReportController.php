<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ProjectReportTrait;

class ProjectReportController extends Controller
{
    use ProjectReportTrait;

    /**
     * Store a newly created ProjectReport in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report_log = str_pad($request->report, count($request->report) + 2, " ",STR_PAD_BOTH);

        $report_json = $this->logProjectReport($report_log, $request->project_id, "jquery", $request->user_id);

        return $report_json;
    }
}
