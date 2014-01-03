@extends('common.master')

@section('additionalHeaders')

@stop

@section('title')
	CS CONNECT.
@stop

@section('content')
	<h2>CS Connect Dashboard</h2>
	<p>
		I'm thinking this page can be used to talk about the connect project, describe some of the features, provide a way to give feedback to the development team, and maybe give some connect usage statistics with some pretty graphs.
	</p>
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
@stop