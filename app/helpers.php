<?php 

use Illuminate\Support\Facades\Auth;
use App\Project;
use App\User;
use App\HearingReport;
use App\Mail\EmailNotification;

function checkActiveSession(){
	$result = false;

	if(Auth::user()){
       $result = true;     
    }

    return $result;
}

function getAllProjects(){

	$projects = Project::all();

	return $projects;
}


function getAllHearingReports() {

    $hearing_reports = HearingReport::all();

    return $hearing_reports;
}

function getUserDetails(){
	$user_id = session()->get('user_id');
    $user = User::where('id', $user_id)
            ->first();

    $user_details = array(
        'full_name' => $user->full_name,
        'user_level' => $user->user_level,
    );

    return $user_details;
}

function checkIfActive($model_name){

    $active_model = $model_name::where('active', 0);

    return $active_model;

}

function sendEmailNotif($message, $mail_prop, $project_id){
    if (!isset($user_id) || $user_id == "") {
        $user_id = Auth::user()->user_id;
    }

    $user = User::where('id', $user_id)
                ->first();
    $fullname = $user->full_name;

    $pos = strrpos($mail_prop, '/');
    $mail_prop = $pos === false ? $mail_prop : substr($mail_prop, $pos + 1);

    Mail::to('gene.mybusybee@gmail.com')->send(new EmailNotification($fullname, $message, $mail_prop, $project_id));
}
?>