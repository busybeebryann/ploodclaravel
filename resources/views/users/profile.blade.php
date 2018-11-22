@extends('app.layout')

@section('content')
	@if($user)
    <div class="page-title">
		<h3>{{$user->first_name}} {{$user->last_name}}</h3>
	</div>
	<div class="col-md-12">
		<div class="col-md-6">
			Gender:
		</div>
		<div class="col-md-6">
			{{$user->gender}}
		</div>

		<div class="col-md-6">
			Date of Birth:
		</div>
		<div class="col-md-6">
			{{$user->birthdate}}
		</div>

		<div class="col-md-6">
			Mobile Number:
		</div>
		<div class="col-md-6">
			{{$user->mobile_number}}
		</div>

		<div class="col-md-6">
			E-mail Address:
		</div>
		<div class="col-md-6">
			{{$user->email}}
		</div>

		<div class="col-md-6">
			Address:
		</div>
		<div class="col-md-6">
			{{$user->address}}
		</div>

		<hr style="width: 100%;">
		
		<div class="col-md-6">
			Username:
		</div>
		<div class="col-md-6">
			{{$user->username}}
		</div>

		<div class="col-md-6">
			User Level:
		</div>
		<div class="col-md-6">
			{{$user->user_level}}
		</div>
	</div>
	<div class="col-md-12" style="margin-top: 30px;">
		<a href="/users/{{$user->id}}/edit" class="btn btn-info" role="button" style="display: inline-block;">Edit</a>
		@if ($user->active)
			<a href="/users/{{$user->id}}/deactivate" class="btn btn-info" role="button" style="display: inline-block; background-color: red; ">Deactivate</a>
		@else
			<a href="/users/{{$user->id}}/activate" class="btn btn-info" role="button" style="display: inline-block;">Activate</a>
		@endif
		
	</div>
	@endif
@endsection