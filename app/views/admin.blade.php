@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('title')
	ADMIN.
@stop

@section('content')

	<div id="messages">
		{{Session::get('message');}}
	</div>
	
	<!-- Generate all recent user posts -->
	<div id="postswrapper">
		{{-- Send Email Button --}}
		<form class="form-horizontal" role="form" action="{{ URL::to('sendEmails/')}}" method="post">
			<div class="col-sm-4">
					{{ Form::select('recipients[]', 
						$all_the_people,
						$user->grad_date,array(
							'multiple',
							'id' => 'rec',
							'style' => 'width:500px'
					))}}
			</div>
			<button id="send_request" type="Send Summary Email" class="btn btn-danger" style="float:right;margin-top:16px;" onclick="return confirm('Are you sure you would like to send the summary email to the following people:.');">
				<span class="glyphicon glyphicon-trash"></span> Send Email
			</button>

		</form>
		<br>
		<br>
		<br>
		<button id="add_all" class="btn">
			Add All Users
		</button>
	</div>
	</br>
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(document).ready(function() { 
			$("#rec").select2({
				placeholder: "Select Message Recipients"
			});
		});
		$("#add_all").click(function () {
			var selected = [];
			$("#rec").find("option").each(function(i,e){
                selected[selected.length]=$(e).attr("value");
            });
			$("#rec").select2("val", selected);
			//$("#rec").select2("data", [
			//	{id: "CA", text: "California"},
			//	{id: "MA", text: "Massachusetts"}
			//]);
		});
		$("#rec").change(function() {
			$('#send_request').attr("onclick","return confirm('Are you sure you would like to send the summary email to: " + $("#rec").val().length + " people?');")
		});
	</script>

@stop