@extends('app.layout')

@section('content')
	<div class="page-title">
		<h3>Project List</h3>
	</div>
	<div class="table-responsive table-striped">
		<table id="projects-datatable" class="table">
			<thead>
				<tr>
					<th class="col-md-5">Projects</th>
					<th class="col-md-5">Collaborators</th>
					@if ($user_details["user_level"] == 4)
						<th class="col-md-5">Actions</th>
					@endif
				</tr>
			</thead>
			
			<tbody>
				@foreach($project_list as $project)
					<tr class="view-user-profile" data-href="/projects/{{$project['id']}}">
						<td>
							{{$project['name']}}
    					</td>
    					<td>
    						@foreach($project['collaborators'] as $collaborator)
    							{{$collaborator}}
    							<br>
    						@endforeach
    					</td>
    					@if ($user_details["user_level"] == 4)
    					<td>
    						<a href="/projects/{{$project['id']}}/edit">
								<i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit Project"></i>
							</a>
							<a href="/projects/{{$project['id']}}/deactivate">
								<i class="fa fa-ban" aria-hidden="true" title="Deactivate Project"></i>	
							</a>
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>	
@endsection

@section('jqueryFunctions')
<script>
    $(document).ready(function(){
        $('#projects-datatable').DataTable({
            "pageLength": 5,
            "lengthMenu": [ 5, 10, 25, 50, 100 ]
        });
    });
</script>
@endsection