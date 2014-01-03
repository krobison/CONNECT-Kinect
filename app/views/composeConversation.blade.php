@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('content')

	{{ Form::open(array('url' => 'createConversation', 'method' => 'POST')) }}
		{{ Form::label('from', 'From') }} {{{ $user->first }}} {{{ $user->last }}}
		<div style="display: none;">
			<input type="text" id="from" name="from" value="{{$user->id}}"/>
		</div>
		<br/>
		<br/>
		<label for="users">To</label><br>
		<select multiple class="select2-container" style="width:500px;" name="users[]">
			@foreach(User::all() as $messageUser)
				{{-- @if($toUser != "none" && $messageUser->id == $toUser->id)
					<option value="{{{ $messageUser->id }}}" selected>{{{ $messageUser->first }}} {{{ $messageUser->last }}}</option>
				@elseif --}}
				@if ($messageUser->id != Auth::user()->id)
					<option value="{{{ $messageUser->id }}}">{{{ $messageUser->first }}} {{{ $messageUser->last }}}</option>
				@endif
			@endforeach
		</select>
		<br/>
		<br/>
			<div class="form-group">
			<label for="name">Subject</label>
				<input type="text" class="form-control" style="width:500px;" id="name" name="name" placeholder="Subject"/>
			</div>
		<br/>
		<div class="form-group">
			<textarea type="text" class="form-control" id="subject" style="width:500px;height:300px;" name="content"></textarea>
		</div>

		<br/>
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-ok"></span> Send Message
		</button>
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



