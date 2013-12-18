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
			
			<h3>
			Basic Information
			@if ($currentuser==$user)
			<span class="editbutton"> <a href="{{ URL::to('editprofile') }}">Edit Profile</a> </span>
			@endif
			</h3>
			
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
	   {{$currentuser->bio}} 	
	</div>
	<div class="feed">
	    <h2>Posts go here</h2>
	</div>
@stop