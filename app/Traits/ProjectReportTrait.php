<?php 
namespace App\Traits;
use Auth;
use App\ProjectReport;
use App\User;
use App\Project;

trait ProjectReportTrait{

	public function logProjectReport($report_log, $project_id, $from="controller", $user_id = ""){

		if (!isset($user_id) || $user_id == "") {
			$user_id = Auth::user()->user_id;
		}

		$user = User::where('id', $user_id)
					->first();
		$project = Project::where('id', $project_id)
					->first();

		$report_message = "User Level " . $user->user_level . ": " . $user->full_name . $report_log . "Project: " . $project->name;

		if ($from == "jquery"){
			$report_message = "User Level " . $user->user_level . ": " . $user->full_name . " " . $report_log . " Project: " . $project->name;
		}

		$project_report_log = new ProjectReport;
		$project_report_log->user_id = $user_id;
		$project_report_log->project_id = $project_id;
		$project_report_log->report_description = $report_message;
		$project_report_log->save();

		if ($from == "jquery"){
			return \Response::json($project_report_log);
		}
	}
}
