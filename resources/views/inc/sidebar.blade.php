<div class="col-sm-4 col-md-2 sidebar-wrapper bg">
	<div class="profile text-center">
		<div class="profile-pic">
			<img src="{{URL::asset('/images/default.jpg')}}">
		</div>
		<div class="profile-info">
			<h3>{{$user_fullname}} </h3>
		</div>
	</div>
	<div id="menu">
		<div class="list-group-item no-padding">
			<a href="#" data-toggle="collapse" data-target="#sm" data-parent="#menu" class="display-inline left">Projects</a>
			<div id="sm" class="sublinks collapse">
				<ul>
					<a href="/projects" class="display-inline"><li class="list-group-item border-none">View Active Projects</li></a>
					@if ($user_level == 4)
					<a href="/projects/archived" class="display-inline"><li class="list-group-item border-none"">View Archived Projects</li></a>
					<a href="/projects/create" class="display-inline"><li class="list-group-item border-none"">Create Project</li></a>
					@endif
				</ul>
			</div>
		</div>
		@if ($user_level == 4)
			<div class="list-group-item  no-padding">
				<a href="#" data-toggle="collapse" data-target="#sl" data-parent="#menu" class="display-inline left">Employees</a>
				<div id="sl" class="sublinks collapse">
					<ul>
						<a href="/users" class="display-inline"><li class="list-group-item border-none"">View Employees</li></a>
						<a href="/users/create" class="display-inline"><li class="list-group-item border-none"">Create Employee</li></a>
					</ul>
				</div>
			</div>
			<div class="list-group-item no-padding">
				<a class="left" href='/user_logs'>User Logs</a>
			</div>
		@endif
		<div class="list-group-item no-padding">
			<a class="left" href='/logout'>Log Out</a>
		</div>
	</div>
</div>