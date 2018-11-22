@extends('app.layout')

@section('content')
    <div class="page-title">
    	<div class="col-md-6">
    		<h3>Employee List</h3>	
    	</div>
    	{{-- <div class="col-md-6">
    		{!! Form::open(['url' => '/users', 'method' => 'GET']) !!}
				<div class="input-group custom-search-form">
					<input type="text" name="search_key" class="form-control" placeholder="Search User">
					<span class="input-group-btn">
						<button class="btn btn-default-sm" type="submit">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			{!! Form::close() !!}
    	</div> --}}
	</div>
	<div class="table-responsive table-striped col-md-12">
		<table id="users-datatable" class="table">
			<thead>
				<tr>
					<th>User ID</th>
					<th>Name</th>
					<th>Date of Birth</th>
					<th>Gender</th>
					<th>Mobile Number</th>
					<th>E-mail Address</th>
					<th>Active</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr class="view-user-profile" data-href="/users/{{$user->id}}">
						<td>{{$user->id}}</td>
						<td>{{$user->first_name . " " . $user->last_name}}</td>
						<td>{{$user->birthdate}}</td>
						<td>{{$user->gender}}</td>
						<td>{{$user->mobile_number}}</td>
						<td>{{$user->email}}</td>
						<td>{{$user->active}}</td>
						<td>
							<a href="/users/{{$user->id}}/edit">
								<i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit User"></i>
							</a>
							@if ($user->active)
								@if($user->id != Auth::user()->user_id)
									<a href="/users/{{$user->id}}/deactivate">
										<i class="fa fa-ban" aria-hidden="true" title="Deactivate User"></i>	
									</a>
								@endif
							@else
								@if($user->id != Auth::user()->user_id)
									<a href="/users/{{$user->id}}/activate">
										<i class="fa fa-check" aria-hidden="true" title="Activate User"></i>	
									</a>
								@endif
							@endif
						</td>
					</tr>
				@endforeach

				{{-- {{ $users->links() }} --}}
			</tbody>
		</table>
	</div>
@endsection

@section('jqueryFunctions')
	<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">        
    <script src="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">

	<script>
       	$(document).ready(function(){
		    $('#users-datatable').DataTable({
		    	"pageLength": 5,
		    	"lengthMenu": [ 5, 10, 25, 50, 100 ]
		    });
		});
   </script>

   <script type="text/javascript">
   		$(document).ready(function($) {
		    $(".view-user-profile").click(function() {
		        window.location = $(this).data("href");
		    });
		});

   </script>

@endsection