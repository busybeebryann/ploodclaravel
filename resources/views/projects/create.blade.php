@extends('app.layout')

@section('content')
	<div class="page-title">
		<h3>Create a Project</h3>
	</div>
	{!! Form::open(['action' => 'ProjectController@store']) !!}
	<div class="project-container col-md-9">
		<div class="form-group">
    		<div class="col-md-4">
	    		{{Form::label('projectname', 'Project Name')}}
	    	</div>
	    	<div class="col-md-6">
	    	{{Form::text('projectname', '', ['class' => 'form-control'])}}
	    	</div>
	    	<div class="col-md-4">
	    		{{Form::label('description', 'Project Description')}}
	    	</div>
	    	<div class="col-md-6">
				{{ Form::textarea('description', '', ['class' => 'form-control'])}}
    		</div>
    		<div class="col-md-10">
    			<h3>Add Collaborators</h3>
    		</div>
    		<div class="col-md-10">
	    		{{Form::label('collaborators', 'User Level 1')}}
	    	</div>
	    	<div class="col-md-10">
		    	<div class="table-responsive table-striped">
		    		<select multiple="multiple" class="form-control" name="collab[collab1[][]]">
					@foreach($users as $user)
						@if ($user->user_level === '1')
							<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
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
							<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
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
								<option value="{{$user->id}}">{{$user->first_name . " " . $user->last_name}}</option>
							@endif
						@endforeach
					</select>
				</div>
    		</div>
    	</div>
		<div class="clearfix"></div>
	    <div class="col-md-3 text-center col-centered">
			{{Form::submit('Submit', ['class' => 'btn btn-primary btn-block'])}}
		</div>
	</div>
	{!! Form::close() !!}
</div>
<div class="clearfix"></div>	
@endsection