<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <title>{{config('app.name', 'PLLO-ODC')}}</title>        
    </head>
    <body>
    	<div class="center-align is-responsive">
        <div class="text-center">
            <img src="{{URL::asset('/images/logo1.png')}}">
        </div>
        <div class="text-center">
            <h3>Online Document Collaboration System</h3>
        </div>
        		@include('inc.messages')
    			@yield('content')
    	</div>
    </body>
</html>
