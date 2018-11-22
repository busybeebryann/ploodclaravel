<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request){

		$this->validate($request, [
            'message' => 'required',
        ]);

		$comment = new Comment;
		$comment->user_id = $request->user_id;
		$comment->project_id = $request->project_id;
		$comment->message = $request->message;
		$comment->save();
		$comment->user;

		//send a notification to admin
		$projectComment = $request->message;
		$project_id = $request->project_id;
		$message = "commented on";

		sendEmailNotif($message, $projectComment, $project_id);
    	return \Response::json($comment);


    }
}
