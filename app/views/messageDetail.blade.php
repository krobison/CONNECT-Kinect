@extends('common.master')

@section('content')
	<div class="page-header">
		<h2>{{{$message->subject}}}</h2>
	</div>
	<div>
		<small> From: {{{$message->sender()->first}}} {{{$message->sender()->last}}} </small><br>
		
		<small> To: {{(string)$message->recipients()}}
		@foreach ($message->recipients() as $recipient)
			{{{$recipient->first}}} {{{$recipient->last}}} 
		@endforeach
		</small>
		
		<br>
		<br>
		
		{{{$message->content}}}
		
		{{--
		@if ($to->id == Auth::user()->id)
		<div>Reply to {{{$from->first}}}$message</div>
		{{ Form::open(array('url' => 'messageTo', 'method' => 'POST')) }}
			{{ Form::label('subject', 'Subject') }} 
			{{ Form::text('subject') }}
			<br/>
			{{ Form::textarea('content') }} 
			<br/>
			{{ Form::submit('Send Message') }}
			{{ Form::hidden('to', $from->id) }}
			{{ Form::hidden('from', $to->id) }}
		{{ Form::close() }}
		</div>
		@endif
		--}}
@stop