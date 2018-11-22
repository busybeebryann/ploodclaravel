@extends('app.login')

@section('content')
    {!! Form::open(['action' => 'UserController@login']) !!}
    	<div class="form-group">
    		{{Form::hidden('user_id', session('user_id'))}}
    	</div>
    	<div class="form-group">
    		{{Form::label('otp', 'One-Time Password*')}}
    		{{Form::text('otp', '', ['class' => 'form-control', 'placeholder' => 'Input your One-Time Password'])}}
        <span class="help-block">*the otp is sent to your email address.</span>
    	</div>
        <div class="col-md-3 text-center col-centered">
    	{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}
@endsection