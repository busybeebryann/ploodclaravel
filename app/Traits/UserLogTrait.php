<?php 
namespace App\Traits;
use Auth;
use App\UserLog;
use App\User;

trait UserLogTrait{

	public function logActivity($activity_log, $user_id = ""){

		if (!isset($user_id) || $user_id == "") {
			$user_id = Auth::user()->user_id;
		}

		$user = User::where('id', $user_id)
					->first();
		
		$log_message = "User Level " . $user->user_level . ": " . $user->full_name . $activity_log;

		$user_log = new UserLog;
		$user_log->user_id = $user_id;
		$user_log->activity = $log_message;
		$user_log->save();

	}
}
