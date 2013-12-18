@extends('common.master')

@section('additionalHeaders')
	
@stop

@section('content')
	<h1> Search Page </h1>
	{{ Form::open(array('url' => 'searchfilter', 'method' => 'GET')) }}
	{{ Form::text('name', null, array( 'placeholder' => 'Search Users')) }}
	{{ Form::Submit('Search') }}
	{{ Form::close() }}
	
	<br>
	
	@if(isset($results))
		@foreach($results as $result) 
		<a href="{{URL::to('profile', $result->id)}}">
		<div class="well">
			@if(is_null($result->picture))
				{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '128', 'height' => '128')) }}
			@else
				{{ HTML::image('assets/img/profile_images/'.$result->picture, 'profile picture', array('width' => '128', 'height' => '128')) }}
			@endif 
			<span> {{ $result->first }} {{ $result->last }} </span>
		</div>
		</a>
		@endforeach
	@endif
@stop