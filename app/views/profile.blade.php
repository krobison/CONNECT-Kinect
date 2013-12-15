@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
@stop

@section('content')
	<div class="basic">
	    <div class="picture">
			@if(is_null($currentuser->picture))
				{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '256', 'height' => '256')) }}
			@else
				{{ HTML::image('assets/img/profile_images/'.$currentuser->picture, 'profile picture', array('width' => '256', 'height' => '256')) }}
			@endif 
	    </div>
	    <div class="info">
	    	<h3>Basic Information</h3>
	    	<span class="infolabel">Name:</span>
	    		<span>{{$currentuser->first}} {{$currentuser->last}}</span><br>
	    	<span class="infolabel">Degree:</span>
	    		<span>{{$currentuser->degree_type}}</span><br>
	    	<span class="infolabel">Graduation Date:</span>
	    		<span>{{$currentuser->grad_date}}</span><br>
	    	<span class="infolabel">Major:</span>
	    		<span>{{$currentuser->major}}</span><br>
	    	<span class="infolabel">Minor:</span>
	    		<span>{{$currentuser->minor}}</span><br>
	    </div>
	    <div class="courses">
	    	<h3>Courses</h3>
			@foreach ($currentuser->courses as $course)
	    		<span class="courselabel">{{$course->prefix}}{{$course->number}} - {{$course->name}}</span>
	    	@endforeach
	    </div>
	</div>
	<div class="custom">
	    <!-- THIS IS SAMPLE CUSTOM CODE -->
	    	<h3 class="hellotext">Welcome to rainbowworld</h3>
	    	<style type="text/css">
	    			@-webkit-keyframes superbackground{
	    				0%{background-color:#0000FF;color:#00FF00;}
	    				50%{background-color:#FF0000;color:#0000FF;}
	    				100%{background-color:#00FF00;color:#FF0000;}
	    			}
	    			.custom{
	    				cursor: url("http://downloads.totallyfreecursors.com/cursor_files/atom.ani"), url("http://downloads.totallyfreecursors.com/thumbnails/atom.gif"), auto;
	    				
	    				-webkit-animation-name: superbackground;
	    				-webkit-animation-duration: 5s;
	    				-webkit-animation-timing-function: linear;
	    				-webkit-animation-delay: 2s;
	    				-webkit-animation-iteration-count: infinite;
	    				-webkit-animation-direction: alternate;
	    				-webkit-animation-play-state: running;
	    			}
	    	</style>
	    	<p>I really really love computer science!!</p>
	    	
	</div>
	<div class="feed">
	    <h2>Posts go here</h2>
	</div>
@stop