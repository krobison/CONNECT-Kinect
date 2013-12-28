@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('content')
	@if(Session::has('message'))	
		<p> {{Session::get('message');}} </p>
	@endif

	{{ Form::open(array('url' => 'messageCompose', 'method' => 'POST')) }}
		{{ Form::label('from', 'From') }} {{{ $user->first }}} {{{ $user->last }}}
		<br/>

		{{ Form::label('toUsers', 'Please select users to message') }}
		<br/>
		<select multiple class="select2-container" style="width:500px;" name="to[]">
			@foreach(User::all() as $user)
				@if($toUser != "none" && $user->id == $toUser->id)
					<option value="{{{ $user->id }}}" selected>{{{ $user->first }}} {{{ $user->last }}}</option>
				@elseif ($user->id != Auth::user()->id)
					<option value="{{{ $user->id }}}">{{{ $user->first }}} {{{ $user->last }}}</option>
				@endif
			@endforeach
		</select>
		<br/><br>
		<div class="form-group">
		<label for="subject" class="control-label">Subject</label>
			<input type="text" class="form-control" id="subject" style="width:500px;" name="subject"/>
		</div><br>
		<div class="form-group">
			<textarea type="text" class="form-control" id="subject" style="width:500px;height:300px;" name="subject"></textarea>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-ok"></span> Send Message
		</button>
		{{ Form::hidden('from', $user->id) }}
	{{ Form::close() }}
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(document).ready(function() { 
			$(".select2-container").select2({
				placeholder: "Select Message Recipients"
			});
		});
	</script>
@stop