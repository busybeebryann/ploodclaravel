@extends('app.login')

@section('content')
    {!! Form::open(['action' => 'UserController@checkUsername']) !!}
    	<div class="form-group">
    		{{Form::label('username', 'Username')}}
    		{{Form::text('username', '', ['class' => 'form-control', 'placeholder' => 'Sign in with your username'])}}
    	</div>
		<div class="col-md-3 text-center col-centered">
    		{{Form::submit('Next', ['class' => 'btn btn-primary btn-block'])}}
    	</div>
    {!! Form::close() !!}
@endsection