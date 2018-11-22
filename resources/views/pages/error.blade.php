@extends('app.layout')
@section('content')
<div class="error_container">
	<h3 class="error_msg alert alert-danger">{{$error}}</h3>
	<a href="/home"><input type="button" class="btn btn-primary error_btn" value="Return to Home"></a>
</div>
@endsection