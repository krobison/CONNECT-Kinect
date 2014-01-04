@extends('common.master')

@section('additionalHeaders')
	<style type="text/css" media="screen">

	</style>
	{{ HTML::script('assets/js/d3.min.js') }}
@stop

@section('title')
	COMMUNITY.
@stop

@section('content')
	<h2>Community Tool</h2>
	<p>
		<!-- This js must be imported before d3 script tags below-->
		This page is a holder for the community tool, this was a tool in some previous connect versions that let people see other's interest areas. We need to integrate the tool in to CS CONNECT and base it around hashtags. So hashtags need to be done first, I'm working on it. -- Thomas
		<script type="text/javascript">
            d3.select("body").append("p").text("New paragraph!");
        </script>
	</p>
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}

@stop