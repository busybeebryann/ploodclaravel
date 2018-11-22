@extends('app.layout')

@section('content')
	<div class="page-title">
		<h3>Create a Report</h3>
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