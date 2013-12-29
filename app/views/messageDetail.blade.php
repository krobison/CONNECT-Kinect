@extends('common.master')

@section('content')
	<div class="page-header">
		<h2>{{{$message->subject}}}</h2>
	</div>
	<div>
		<small> <b> From: </b> {{{$message->sender()->first}}} {{{$message->sender()->last}}} </small><br>
		
		<small> <b> To: </b>
		@foreach ($message->recipients as $recipient)
			{{{$recipient->first}}} {{{$recipient->last}}} ;
		@endforeach
		</small>
		
		<br>
		<br>
		
		{{{$message->content}}}
		
		<hr>
		
		<div>Reply to {{{$message->sender()->first}}}
		{{ Form::open(array('url' => 'messageTo', 'method' => 'POST')) }}
			{{ Form::label('subject', 'Subject') }} 
			{{ Form::text('subject', 'Re:'.$message->subject) }}
			<br>
			{{ Form::textarea('content') }} 
			<br>
			{{ Form::submit('Send Message') }}
			{{-- Form::hidden('to', $from->id) --}}
			{{-- Form::hidden('from', $to->id) --}}
		{{ Form::close() }}
		</div>
	</div>
@stop