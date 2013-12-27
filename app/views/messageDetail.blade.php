@extends('common.master')

@section('content')
	<div class="page-header">
		<h2>{{{$message->subject}}}</h2>
	</div>
	<div>
		<small> From {{{$from->first}}} {{{$from->last}}}</small><br>
		<small> To {{{$to->first}}} {{{$to->last}}}</small><br><br>
		{{{$message->content}}}
		
		@if ($to->id == Auth::user()->id)
		<div>Reply to {{{$from->first}}}</div>
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
@stop