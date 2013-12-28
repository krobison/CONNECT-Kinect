@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::script('assets/js/select2.js') }}
@stop

@section('content')
	{{ Form::open(array('url' => 'messageCompose', 'method' => 'POST')) }}
		{{ Form::label('from', 'From') }} {{ $user->first }} {{ $user->last }}
		<br/>

		{{ Form::label('toUsers', 'Please select users to message') }}
		<br/>
		<select multiple class="select2-container" name="to[]">
			@foreach(User::all() as $user)
				@if($toUser != "none" && $user->id == $toUser->id)
					<option value="{{ $user->id }}" selected>{{ $user->first }} {{ $user->last }}</option>
				@elseif ($user->id != Auth::user()->id)
					<option value="{{ $user->id }}">{{ $user->first }} {{ $user->last }}</option>
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
@stop