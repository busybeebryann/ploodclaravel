@extends('app.layout')

@section('content')
    <div class="page-title">
    	<div class="col-md-6">
    		<h3>User Logs</h3>	
    	</div>
	</div>
	<div class="table-responsive table-striped col-md-12">
		<table id="logs-datatable" class="table">
			<thead>
				<tr>
					<th>Activity</th>
					<th>Timestamp</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($user_logs as $user_log)
					<tr>
						<td>{{$user_log->activity}}</td>
						<td>{{$user_log->created_at}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section('jqueryFunctions')
	<script>
        $(document).ready(function(){
            $('#logs-datatable').DataTable({
                "pageLength": 5,
                "lengthMenu": [ 5, 10, 25, 50, 100 ],
                "order": [[1, "desc"]],
            });
        });
   </script>
@endsection
