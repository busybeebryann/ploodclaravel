@extends('app.layout')

@section('content')
    <div class="page-title">
		<h3>Update Project</h3>
	</div>
	<div>
		@if($project_details)
		{!! Form::open(['url' => '/projects/' . $project_details->id, 'method' => 'PUT']) !!}
		<div class="project-container col-md-9">
			<div class="form-group">
	    		<div class="col-md-4">
		    		{{Form::label('projectname', 'Project Name')}}
		    	</div>
		    	<div class="col-md-6">
		    	{{Form::text('projectname', $project_details->name, ['class' => 'form-control'])}}
		    	</div>
		    	<div class="col-md-4">
		    		{{Form::label('description', 'Project Description')}}
		    	</div>
		    	<div class="col-md-6">
					{{ Form::textarea('description', $project_details->description, ['class' => 'form-control'])}}
	    		</div>
	    		<div class="col-md-10">
	    			<h3>Edit Collaborators</h3>
	    		</div>
	    		<div class="col-md-10">
		    		{{Form::label('collaborators', 'User Level 1')}}
		    	</div>
		    	<div class="col-md-10">
			    	<div class="table-responsive table-striped">
			    		<select multiple="multiple" class="form-control" name="collab[collab1[][]]">
						@foreach($users as $user) 
							@if ($user->user_level === '1')
								<?php $isAdded = false; ?>
								@foreach($collab_details as $collab)
									@if ($user->id === $collab->user_id)
										<option selected value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
										<?php $isAdded = true; ?>
									@endif
								@endforeach
								@if (!$isAdded)
									<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
								@endif
							@endif
						@endforeach
						</select>
					</div>
	    		</div>
	    		<div class="col-md-10">
		    		{{Form::label('collaborators', 'User Level 2')}}
		    	</div>
		    	<div class="col-md-10">
			    	<div class="table-responsive table-striped">
			    		<select multiple="multiple" class="form-control" name="collab[collab2[][]]">
						@foreach($users as $user)
							@if ($user->user_level === '2')
								<?php $isAdded = false; ?>
								@foreach($collab_details as $collab)
									@if ($user->id === $collab->user_id)
										<option selected value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
										<?php $isAdded = true; ?>
									@endif
								@endforeach
								@if (!$isAdded)
									<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
								@endif
							@endif
						@endforeach
						</select>
					</div>
	    		</div>
	    		<div class="col-md-10">
		    		{{Form::label('collaborators', 'User Level 3')}}
		    	</div>
		    	<div class="col-md-10">
			    	<div class="table-responsive table-striped">
			    		<select multiple="multiple" class="form-control" name="collab[collab3[][]]">
						@foreach($users as $user)
							@if ($user->user_level === '3')
								<?php $isAdded = false; ?>
								@foreach($collab_details as $collab)
									@if ($user->id === $collab->user_id)
										<option selected value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
										<?php $isAdded = true; ?>
									@endif
								@endforeach
								@if (!$isAdded)
									<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
								@endif
							@endif
						@endforeach
						</select>
					</div>
	    		</div>
	    	</div>
			<div class="clearfix"></div>
		    <div class="col-md-3 text-center col-centered">
				{{Form::submit('Update', ['class' => 'btn btn-primary btn-block'])}}
			</div>
		</div>
	    {!! Form::close() !!}
	    @endif
	</div>
@endsection