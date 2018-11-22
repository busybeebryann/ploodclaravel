<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLog;

class UserLogController extends Controller
{
	public function index(){
		
		$user_details = getUserDetails();

		if ($user_details["user_level"] == 4){
			$user_logs = UserLog::latest()->get();

			return view('user_log.index')->with('user_logs', $user_logs)
										->with('user_details', $user_details);
		}else{
			return view('pages.error')->with('error', 'Access Denied. You are not allowed to access this page!')
									  ->with('user_details', $user_details);
		}
    }
}
