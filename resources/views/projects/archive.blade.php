@extends('app.layout')

@section('content')
	<div class="page-title">
		<h3>Archived Projects</h3>
	</div>
	<div class="table-responsive table-striped">
		<table class="table">
			<thead>
				<tr>
					<th class="col-md-5">Projects</th>
					<th class="col-md-5">Collaborators</th>
				</tr>
			</thead>
			<tbody>
				@foreach($project_list as $project)
					<tr>
						<td>
							<a href="/projects/{{$project['id']}}">
							{{$project['name']}}
							</a>			
    					</td>
    					<td>
    						@foreach($project['collaborators'] as $collaborator)
    							{{$collaborator}}
    							<br>
    						@endforeach
    					</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>	
@endsection