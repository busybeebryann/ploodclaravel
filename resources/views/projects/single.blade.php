@extends('app.layout')

@section('content')

@if($project)
<div class="page-title">
	<h3>{{$project->name}}</h3>
</div>
<div style="height: 78%; border: 1px solid #d3e0e9;">
	<div class="table-responsive table-striped col-md-8 no-padding" style="height: 75%;">
		<table class="table">
			<thead>
				<tr>
					<th class="col-md-8">

						<div class="col-md-10"> 
							{!! Form::open(['action' => 'ProjectFileController@store', 'files' => true]) !!}
							<input type="file" id="file" multiple="multiple" name="uploadFile[]" class="project-reports uploadFile">
							{{Form::hidden('project_id', $project->id, ['id' => 'project_id'])}}
							{{ Form::submit('Upload', 
							[
							'id' => 'upload-btn',
							'class' => 'btn btn-primary btn-sm project-reports',
							'data-target' => '#progressModal',
							'data-toggle' => 'modal'
							]
							)}}
							{!! Form::close() !!}
							<!-- Progress Bar Modal -->
							<div class="modal fade" id="progressModal" role="dialog" data-keyboard="false" data-backdrop="static">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Please wait while your file is being uploaded.</h4>
										</div>
										<div class="modal-body">
											<div id="modal-message" class="text-center">
												<span id="status"></span>
												<progress id="progressBar" value="0" max="100" style="width: 90%; margin: 0 auto;"></progress>
												<button id="abort" class="btn btn-primary" onClick="cancelUpload()">Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Progressbar modal end -->

						</div>
						<!-- <div class="col-md-2">
							{!! Form::open(['action' => 'ProjectFileController@store']) !!}
							{{Form::hidden('project_id', $project->id, ['id' => 'project_id'])}}
							{{ Form::submit('Create a report', 
							[
							'id' => 'create-report',
							'class' => 'btn btn-success'
							]
							)}}
							{!! Form::close() !!}
						</div> -->
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="no-padding">
						<div class="table-responsive table-striped">
							<table class="table">
								<thead>
									<tr>
										<th class="col-xs-1 mime-type"></th>
										<th class="col-md-8">Filename</th>
										<th class="col-md-2">Date Uploaded</th>
										<th class="col-md-2">Actions</th>
									</tr>
								</thead>
								<tbody>
									
									@foreach($project['project_file']->sortByDesc('created_at') as $project_file)
									<tr>
										<td><i id="fa-id" class="fa {{$project_file['mimetype']}}" aria-hidden="true"></i></td>
										<td id="filename">{{$project_file['file_name']}}</td>
										<td>{{$project_file['created_at']}}</td>
										<td>
											{!! Form::open(['action' => 'ProjectFileController@download', 'class' => 'display-inline', 'id' => 'download-button']) !!}
											{{Form::hidden('project_id', $project->id, ['id' => 'project_id'])}}
											{{Form::hidden('project_name', $project->name, ['name' => 'project_name'])}}
											{{Form::hidden('project_file', $project_file['file_path'], ['id' => 'project_file'])}}
											{{Form::button('<i class="fa fa-download" aria-hidden="true" title="Download"></i>', array('type' => 'submit', 'class' => 'button-facade'))}}
											{!! Form::close() !!}
											<!-- Delete -->
											{!! Form::open(['action' => 'ProjectFileController@delete', 'class' => 'display-inline', 'id' => 'delete-button']) !!}
											{{Form::hidden('project_file_id', $project->id, ['id' => 'project_file'])}}
											{{Form::hidden('project_file_path', $project_file['file_path'], ['id' => 'project_file'])}}
											{{Form::button('<i class="fa fa-ban" aria-hidden="true" title="Delete"></i>', 
											['type' => 'submit', 
											'class' => 'button-facade',
											'onClick' => "return confirm('Are you sure you want to delete this?')"])}}
											{!! Form::close() !!}									
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4" style="height: 55%; border-left: 1px solid #d3e0e9;">
		<div class="table-responsive table-striped" style="height: 100%;" >
			<table class="table" id="comment-table">
				<thead>
					<tr>
						<th class="col-md-4">Project Comments</th>
					</tr>
				</thead>
				<tbody id="comment-list" name="comment-list">
					<?php $row_count = 0; ?>
					@foreach($project->comments as $comment)
					<tr id={{"row-" . ++$row_count}}>
						<td style="border: none;">
							@include('inc.comment', ['comment' => $comment])
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div>
			{!! Form::open(['action' => 'CommentController@store','class' => 'form-inline', 'id' => 'comment_box']) !!}
			{{ Form::token() }}
			{{Form::hidden('project_id', $project->id, ['id' => 'project_id'])}}
			{{Form::hidden('user_id', Auth::user()->user_id, ['id' => 'user_id'])}}
			{{ Form::textarea('message', null, ['id' => 'message', 'class' => 'form-control', 'size' => '20x3', 'placeholder' => 'Message']) }}
			{{Form::submit('Send', ['id' => 'send_message', 'class' => 'btn btn-primary'])}}
			{!! Form::close()!!}
		</div>
	</div>
	<div class="table-responsive table-striped col-md-12" style="height: 25%; border-top: 1px solid #d3e0e9;">
		<table class="table" id="report-table">
			<thead>
				<tr>
					<th class="col-md-8">Project Log</th>
					<th class="col-md-4">Date</th>
				</tr>
			</thead>
			<tbody id="report-list" name="report-list">
				<?php $report_count = 0; ?>
				@foreach ($project->project_reports as $project_report)
				<tr id={{"report_row-" . ++$report_count}}>
					<td>
						{{$project_report->report_description}}
					</td>
					<td>
						{{$project_report->created_at}}
					</td>
				</tr>
				@endforeach

			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
@endif
@endsection

@section('jqueryFunctions')
<script type="text/javascript">
	$('#send_message').attr('disabled', true);
	$('#message').keyup(function(){
		if($(this).val().length != 0)
			$('#send_message').attr('disabled', false);
		else
			$('#send_message').attr('disabled', true);
	});

	var comment_rows_length = document.getElementById("comment-table").rows.length;

	if(comment_rows_length > 1){
			//in the Project Comments Table, scroll to the last row for the latest comment
			var current_rows = document.getElementById("comment-table").rows.length - 1;
			var latest_row_id = document.getElementById("row-" + current_rows);
			latest_row_id.scrollIntoView();
		}

		var report_rows_length = document.getElementById("report-table").rows.length;

		if (report_rows_length > 1){
			//in the Project Logs Table, scroll to the last row for the latest activity
			var current_report_rows = document.getElementById("report-table").rows.length - 1;
			var latest_report_row_id = document.getElementById("report_row-" + current_report_rows);
			latest_report_row_id.scrollIntoView();	
		}

		//Add the current user new comment to database
		$('#comment_box').submit(function(e){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('input[name="_token"]').val()
				}
			})

			e.preventDefault();

			var formData = {
				project_id: $('#project_id').val(),
				user_id: $('#user_id').val(),
				message: $('#message').val(),
			}

			var type = "POST";
			var url = "/comments";

			$.ajax({
				type: type,
				url: url,
				data: formData,
				dataType: 'json',
				success: function (data){

					var current_rows = document.getElementById("comment-table").rows.length;
					var new_row = current_rows++;

					var new_comment = '<tr id="row-' + new_row + '"><td style="border: none;"><div class="comment-bubble" style="text-align: right; padding-right: 10px;">';
					new_comment += '<h4>' + data.user.first_name + ' ' + data.user.last_name + '</h4><h6>' + data.created_at + '</h6><p>' + data.message + '</p>';
					new_comment += '</div></td></tr>';

					$('#comment-list').append(new_comment);
					
					var latest_row_id = document.getElementById("row-" + new_row);
					latest_row_id.scrollIntoView();

					$('#message').val("");
					saveProjectReport(data.project_id, data.user_id, "added the Comment: \"" + data.message + "\" to");
				},
				error: function (data){
					console.log('Error: ', data);
				}
			});

		})

		function saveProjectReport(project_id, user_id, report){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('input[name="_token"]').val()
				}
			})

			var formData = {
				project_id: project_id,
				user_id: user_id,
				report: report,
			}

			var type = "POST";
			var url = "/project_reports";

			$.ajax({
				type: type,
				url: url,
				data: formData,
				dataType: 'json',
				success: function (data){

					var current_report_rows = document.getElementById("report-table").rows.length;
					var new_report_row = current_report_rows++;

					var new_report = '<tr id="report_row-' + new_report_row + '">';
					new_report += '<td>' + data.report_description + '</td>';
					new_report += '<td>' + data.created_at + '</td></tr>';

					$('#report-list').append(new_report);
					
					var latest_report_row_id = document.getElementById("report_row-" + new_report_row);
					latest_report_row_id.scrollIntoView();

				},
				error: function (data){
					console.log('Error: ', data);
				}
			});
		}

</script>

<script type="text/javascript">

			var form = document.querySelector('form');
			var file = document.getElementById('file');
			var ajax = new XMLHttpRequest();
			var div = document.getElementById('modal-message');
			var message = document.createElement('h3'); // create new h3
			message.id = "message";

			form.addEventListener('submit',function(e){
				e.preventDefault();

				//multiple files in the form parameter
				var formdata = new FormData(form);

				// check if file is selected
		        if (file.files.length > 0) {
		            // loop to check each file
		            for (var i = 0; i <= file.files.length - 1; i++) {

		                var fsize = file.files.item(i).size;      // file size
						var realsize = Math.round((fsize / 1024));

						if(realsize > 100000){
			   				div.appendChild(message);
							document.getElementById("message").innerHTML = "File is too large! Please try again.";
    						document.getElementById("progressBar").style.display = 'none';
							document.getElementById("abort").style.display = 'none';
							setTimeout(function(){ 
								div.removeChild(message);
								document.getElementById("close").click();
			   				}, 3000);
						}
						else {
							document.getElementById("progressBar").style.display = 'inline';
							document.getElementById("abort").style.display = 'inline';

							ajax.open('post', '/upload'); //route laravel
							ajax.send(formdata);
						}
		            }
				}else{
					//put something here to prevent user from proceeding when there are no files to upload but the user clicked the upload button
				}

			},false);

			ajax.upload.addEventListener('progress', function(e){

				var percent = (e.loaded/e.total) * 100;
				var percentnumber = Math.round(percent);
				if(percentnumber > 90){
					document.getElementById("abort").style.display = 'none';
				}
				document.getElementById("progressBar").value = Math.round(percent);
				document.getElementById("status").innerHTML = Math.round(percent) + "%";

			},false);

			ajax.addEventListener('load', function(e){
				div.appendChild(message);
				document.getElementById("message").innerHTML = "File has been uploaded!";
				setTimeout(function(){ 
					document.getElementById("close").click();
					//location.reload();
   				}, 2000);
			},false);

			ajax.onload = function () {
			  if(ajax.status == 413){
			  	div.appendChild(message);
				document.getElementById("message").innerHTML = "File is too large! Please try again.";
				setTimeout(function(){ 
					document.getElementById("close").click();
					//location.reload();
   				}, 4000);
			  }
			};

			function cancelUpload(){
				ajax.abort();
			}

			ajax.addEventListener('abort', function(e){
				div.appendChild(message);
				document.getElementById("message").innerHTML = "File upload cancelled.";
				setTimeout(function(){ 
					document.getElementById("close").click();
					//location.reload();
   				}, 3000);
			},false);

			ajax.addEventListener('error', function(e){
				div.appendChild(message);
				document.getElementById("message").innerHTML = "File upload error, connection reset! Please try again.";
				setTimeout(function(){ 
					document.getElementById("close").click();
					//location.reload();
   				}, 4000);
   			},false);

   		</script>
   		@endsection