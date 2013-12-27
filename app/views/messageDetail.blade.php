@extends('common.master')

@section('content')
	<div class="page-header">
		<h2>{{{$message->subject}}}</h2>
	</div>
	<div>
		<small> From {{{$from->first}}} {{{$from->last}}}</small><br>
		<small> To {{{$to->first}}} {{{$to->last}}}</small><br><br>
		{{{$message->content}}}
	</div>
@stop