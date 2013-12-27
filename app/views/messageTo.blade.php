@extends('common.master')

@section('content')
	{{ Form::open(array('url' => 'messageTo', 'method' => 'POST')) }}
		{{ Form::label('from', 'From') }} {{ $user->first }} {{ $user->last }}
		<br/>
		{{ Form::label('to', 'To') }} {{$toUser->first}} {{$toUser->last}}
		<br/>
		{{ Form::label('subject', 'Subject') }} 
		{{ Form::text('subject') }}
		<br/>
		{{ Form::textarea('content') }} 
		<br/>
		{{ Form::submit('Send Message') }}
		{{ Form::hidden('to', $toUser->id) }}
		{{ Form::hidden('from', $user->id) }}
	{{ Form::close() }}
@stop