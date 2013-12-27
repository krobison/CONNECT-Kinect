@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
@stop

@section('content')
	<div class="basic">
		<div class="row">
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
					<form class="form-horizontal" role="form" action="{{ URL::to('editprofile') }}" method="get">
						<button type="submit" class="btn btn-default btn editbutton">
							<span class="glyphicon glyphicon-edit"></span> Edit Profile
						</button>
					</form>
				@endif
				</h3>
				
				<span class="infolabel">Name:</span>
				<span>{{{$currentuser->first}}} {{$currentuser->last}}</span><br>
					
				@if (!empty($currentuser->degree_type))
					<span class="infolabel">Degree:</span>
					<span>{{{$currentuser->degree_type}}}</span><br>
				@endif
				@if (!empty($currentuser->grad_date))
					<span class="infolabel">Graduation Date:</span>
					<span>{{{$currentuser->grad_date}}}</span><br>
				@endif
				@if (!empty($currentuser->major))
					<span class="infolabel">Major:</span>
					<span>{{{$currentuser->major}}}</span><br>
				@endif
				@if (!empty($currentuser->minor))
					<span class="infolabel">Minor:</span>
					<span>{{{$currentuser->minor}}}</span><br>
				@endif
			</div>
			@if (Auth::user()->id != $currentuser->id)
			<div class="info">
				<form class="form-horizontal" role="form" action="{{ URL::to('messageUser', $currentuser->id) }}" method="get">
					<button type="submit" class="btn btn-default btn-lg">
						<span class="glyphicon glyphicon-envelope"></span> Message {{{$currentuser->first}}} {{{$currentuser->last}}}
					</button>
				</form>
			</div>
			@endif
		</div>
		<div class="row">
			@if (!empty($studentClasses))
				<div class="courses">
					<h3>Courses Taking</h3>
					@foreach ($studentClasses as $course)
						<span class="courselabel">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
					@endforeach
				</div>
			@endif
			@if (!empty($teacherClasses))
				<div class="courses">
					<h3>Courses Teaching</h3>
					@foreach ($teacherClasses as $course)
						<span class="courselabel">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
					@endforeach
				</div>
			@endif
		</div>
	</div>
	<div class="custom">
	   {{$currentuser->bio}} 	
	</div>
	<div class="feed">
	    @foreach ($posts as $post)
			@if ($post->postable_type != "PostHelpRequest" || $post->postable->anonymous != 1)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
			@endif
		@endforeach
	</div>
@stop