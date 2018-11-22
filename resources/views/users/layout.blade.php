@extends('app.layout')

@section('content')
    <div class="container center-align is-responsive home-layout">
    	<div class="content-holder">
    		@include('inc.sidebar', ['user_fullname' => $user_details['full_name']])
	    	<div class="col-sm-9 col-md-9 no-padding">
	    		<div class="head-layout">
	    			<div class="head-logo head">
	    				<img src="{{URL::asset('/images/logo1.png')}}">
	    			</div>
	    			<div class="head-title head">
	    				<h3>Online Document Collaboration</h3>
	    			</div>
	    			<div class="clearfix"></div>	
	    		</div>
	    		@yield('user-content')
	    	</div>
	    	<div class="clearfix"></div>	
    	</div>
    </div>
@endsection