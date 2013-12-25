@extends('common.master')

@section('additionalHeaders')
	<style type="text/css" media="screen">

	</style>
@stop

@section('content')
	<h2>Community Tool</h2>
	<p>
		This page is a holder for the community tool, this was a tool in some previous connect versions that let people see other's interest areas. We need to integrate the tool in to CS CONNECT and base it around hashtags. So hashtags need to be done first, I'm working on it. -- Thomas
	</p>
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	
@stop