@if ($comment->user->id == Auth::user()->user_id)
	<div class="comment-bubble" style="text-align: right; padding-right: 10px;">
		<h4>{{$comment->user->full_name}}</h4>
		<h6>{{$comment->created_at}}</h6>
		<p>{{$comment->message}}</p>
	</div>
@else
	<div class="comment-bubble" style="padding-left: 10px;">
		<h4>{{$comment->user->full_name}}</h4>
		<h6>{{$comment->created_at}}</h6>
		<p>{{$comment->message}}</p>
	</div>
@endif