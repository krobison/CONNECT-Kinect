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
		<br/>
		<select multiple class="select2-container" style="width:500px;">
			@foreach(User::all() as $messageUser)
				@if($toUser != "none" && $messageUser->id == $toUser->id)
					<option value="{{{ $messageUser->id }}}" selected>{{{ $messageUser->first }}} {{{ $messageUser->last }}}</option>
				@elseif ($messageUser->id != Auth::user()->id)
					<option value="{{{ $messageUser->id }}}">{{{ $messageUser->first }}} {{{ $messageUser->last }}}</option>
				@endif
			@endforeach
		</select>
		<br/>
		<div class="form-group">
		<br/>
			<input type="text" placeholder="Subject" class="form-control" id="subject" style="width:500px;" name="subject"/>
		</div><br>
		<div class="form-group">
			<textarea type="text" class="form-control" id="subject" style="width:500px;height:300px;" name="content"></textarea>
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
				placeholder: "To"
			});
		});
	</script>
@stop