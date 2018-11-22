@extends('app.layout')

@section('content')
    <div class="page-title">
		<h3>Update Employee</h3>
	</div>
	<div>
		@if($user)
		{!! Form::open(['url' => '/users/' . $user->id, 'method' => 'PUT']) !!}
	    	<div class="form-group">

	    		<div class="col-md-4">
	    			{{Form::label('first_name', 'First Name')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{Form::text('first_name', $user->first_name, ['class' => 'form-control'])}}
	    		</div>
	    		
	    		<div class="col-md-4">
	    			{{Form::label('last_name', 'Last Name')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{Form::text('last_name', $user->last_name, ['class' => 'form-control'])}}
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('gender', 'Gender')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{ Form::select('gender', [
					   'male' => 'Male',
					   'female' => 'Female'],
					   $user->gender,
					   ['class' => 'form-control']
					) }}
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('birthdate', 'Date of Birth')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{ Form::text('birthdate', $user->birthdate, ['id' => 'datepicker', 'class' => 'form-control']) }}
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('mobile_no', 'Mobile Number')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{Form::text('mobile_no', $user->mobile_number, ['class' => 'form-control'])}}
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('email', 'E-mail Address')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{ Form::email('email', $user->email, ['class' => 'form-control']) }}
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('address', 'Address')}}
	    		</div>
	    		<div class="col-md-6">
	    			{{ Form::textarea('address', $user->address, ['class' => 'form-control', 'size' => '30x3']) }}
	    		</div>

	    		<hr style="width: 100%;">
	    		
	    		<div class="col-md-4">
	    			{{Form::label('username', 'Username')}}	
	    		</div>
	    		<div class="col-md-6">
	    			{{Form::text('username', $user->username, ['class' => 'form-control'])}}	
	    		</div>

	    		<div class="col-md-4">
	    			{{Form::label('user_level', 'User Level')}}	
	    		</div>
	    		<div class="col-md-6">
	    			{{ Form::select('user_level', [
	    					'1' => '1',
		    				'2' => '2',
		    				'3' => '3',
		    				'4' => '4',
		    			],
					   $user->user_level,
					   ['class' => 'form-control']
					) }}
	    		</div>

	    	</div>
			<div class="col-md-3 text-center col-centered">
	    		{{Form::submit('Update', ['class' => 'btn btn-primary btn-block'])}}
	    	</div>
	    {!! Form::close() !!}
	    @endif
	</div>
@endsection

@section('jqueryFunctions')
	<script type="text/javascript">
		$(function() {
	        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	    });	
	</script>
@endsection