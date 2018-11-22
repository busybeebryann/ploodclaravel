<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <title>{{config('app.name', 'PLLO-ODC')}}</title>        
    </head>
    <body>
        <div class="container center-align is-responsive home-layout">
            @include('inc.messages')
            <div class="content-holder">
                @include('inc.sidebar', ['user_fullname' => $user_details['full_name'], 'user_level' => $user_details['user_level']])
                <div class="col-sm-9 col-md-10 no-padding" style="height: 100%;">
                    <div class="head-layout">
                        <div class="head-logo head">
                            <img src="{{URL::asset('/images/logo1.png')}}">
                        </div>
                        <div class="head-title head">
                            <h3>Online Document Collaboration</h3>
                        </div>
                        <div class="clearfix"></div>    
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
    <footer>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">        
        <script src="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">

        
        
       <script type="text/javascript">
            $(document).ready(function($) {
                $(".view-user-profile").click(function() {
                    window.location = $(this).data("href");
                });
            });

       </script>

        <script type="text/javascript">
            setInterval(function() {
                var type = "GET";
                var url = "/checkIfActive";

                $.ajax({
                    type: type,
                    url: url,
                    data: "",
                    success: function (data){
                        if(data == "deactivated"){
                            console.log(data);
                            alert("Your account has been deactivated! Please contact the administrator.");
                            window.location.href = '/logoutDeactivated';
                        }else {
                            console.log(data);
                        }
                    },
                    error: function (data){
                        console.log('Error: ', data);
                    }
                });
            }, 3000);
        </script>
        
        @yield('jqueryFunctions')
    </footer>

</html>
