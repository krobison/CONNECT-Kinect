@extends('common.master')

@section('content')
	<div class="page-header">
		<h2>{{{$message->subject}}}
		<small> From {{{$from->first}}} {{{$from->last}}}</small></h2>
	</div>
	<div>
		{{{$message->content}}}
	</div>
@stop