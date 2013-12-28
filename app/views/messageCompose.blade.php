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
		<select multiple class="select2-container" style="width:80%" name="to[]">
			@foreach(User::all() as $user)
				@if($toUser != "none" && $user->id == $toUser->id)
					<option value="{{{ $user->id }}}" selected>{{{ $user->first }}} {{{ $user->last }}}</option>
				@elseif ($user->id != Auth::user()->id)
					<option value="{{{ $user->id }}}">{{{ $user->first }}} {{{ $user->last }}}</option>
				@endif
			@endforeach
		</select>
		<br/>
		{{ Form::label('subject', 'Subject') }} 
		{{ Form::text('subject') }}
		<br/>
		{{ Form::textarea('content') }} 
		<br/>
		{{ Form::submit('Send Message') }}
		{{ Form::hidden('from', $user->id) }}
	{{ Form::close() }}
	
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(".select2-container").select2({
			placeholder: "Select Message Recepient(s)"
		});
	</script>
@stop