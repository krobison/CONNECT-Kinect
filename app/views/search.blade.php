@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/search.css') }}
	<style>
	#search-title:hover
	{ 
		background-color:orange;
	}
	</style>
@stop

@section('title')
	USER SEARCH.
@stop

@section('content')
	<h2> User Search Page </h2>
	<div class="panel panel-default">
	    <div id="search-title" class="panel-heading">
			<h4>
			Search
			</h4>
		</div>
		<div id="new-post-body" class="panel-body">
		<div class="form-group">
		
		{{ Form::open(array('url' => 'searchfilter', 'method' => 'GET')) }}
		<div style="width:100%;">
		@if(!empty($name))
		{{ Form::text('name', $name, array( 
		'placeholder' => 'Search User Names and Bios',
		'class' => 'form-control'
		)) }}
		@else
		{{ Form::text('name', null, array( 
		'placeholder' => 'Search for Users by Name and Bio',
		'class' => 'form-control'
		)) }}
		@endif
		</div>
		</div>
		<div class="form-group">
				<select multiple style="width:100%;" class="select2-container classSelect" name="classes[]">
					<optgroup label="Computer Science">
						@foreach(Course::all() as $course)
							<option value={{ $course->id }}>{{ $course->prefix }}{{ $course->number }} - {{ $course->name }}</option>
						@endforeach
					</optgroup>
					@if (!empty($searchCourses))
						@foreach($searchCourses as $course)
							<option selected value={{{ $course->id }}}>
								{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}
							</option>
						@endforeach
					@endif
				</select>
		</div>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Search', array('class' => 'btn btn-primary btn-block'))}}	
				{{ Form::close() }}
			</div>
			<div class ="col-xs-4 col-md-3">
				<a href="{{URL::to('showallusers')}}">
				<button class="btn btn-primary btn-block">Show all users</button>
			</div>
		</div>
		
		
		</div>
	</div>
	
	@if(isset($nameresults))
	@if(!empty($nameresults))
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Matching Names
			</h4>
		</div>
		<div id="name-body" class="panel-body">
	@endif
		@foreach($nameresults as $result) 
		<div style="margin-bottom:16px;padding:8px;border:1px #CCCCCC solid;border-radius:4px;"> 
			<div class="row">
				<div class="picture">
					<a href="{{URL::to('profile', $result->id)}}">
					@if(is_null($result->picture))
						{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '128', 'height' => '128')) }}
					@else
						{{ HTML::image('assets/img/profile_images/'.$result->picture, 'profile picture', array('width' => '128', 'height' => '128')) }}
					@endif
					</a>
				</div>
				<div class="info">
				<span>
				<h3><a href="{{URL::to('profile', $result->id)}}">{{{ $result->first }}} {{{ $result->last }}} </a></h3>
				</span>
				
				<span>
				<?php $strippedBio = strip_tags($result->bio); ?>
				@if (strlen($strippedBio) > 55)
                   <p> {{{ substr($strippedBio,0,55)."..." }}} </p> 
                @else
                   <p>{{{ $strippedBio }}} </p> 
                @endif
				</span>

				<span class="infolabel"><b>Classes:</b></span> </br>
				<span>
					@foreach(User::find($result->id)->courses as $course)
						@if (!empty($searchCourses))
							@foreach($searchCourses as $searchCourse)
								@if($course->id == $searchCourse->id)
									<span class="courselabelmatch">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
								@endif
							@endforeach 
						@endif
					@endforeach
					@foreach(User::find($result->id)->courses as $course)
						<?php $t = false ?>
						@if (!empty($searchCourses))
							@foreach($searchCourses as $searchCourse)
								@if($course->id == $searchCourse->id)
									<?php $t = true ?>
								@endif
							@endforeach 
						@endif
						@if(!$t)
							<span class="courselabel">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
						@endif
					@endforeach
				</span>
					
				</div>
			</div>
			
		</div>
		@endforeach
		@if(!empty($nameresults))
		</div>
		</div>
		@endif
	@endif
	
	@if(isset($bioresults))
	@if(!empty($bioresults))
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Matching Bios
			</h4>
		</div>
		<div id="bio-body" class="panel-body">
	@endif
		@foreach($bioresults as $result) 
		<div style="margin-bottom:16px;padding:8px;border:1px #CCCCCC solid;border-radius:4px;"> 
			<div class="row">
				<div class="picture">
					<a href="{{URL::to('profile', $result->id)}}">
					@if(is_null($result->picture))
						{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '128', 'height' => '128')) }}
					@else
						{{ HTML::image('assets/img/profile_images/'.$result->picture, 'profile picture', array('width' => '128', 'height' => '128')) }}
					@endif
					</a>
				</div>
				<div class="info">
				<span>
				<h3><a href="{{URL::to('profile', $result->id)}}">{{{ $result->first }}} {{{ $result->last }}} </a></h3>
				</span>
				
				<span>
				<?php $strippedBio = strip_tags($result->bio); ?>
				@if (strlen($strippedBio) > 55)
                   <p> {{{ substr($strippedBio,0,55)."..." }}} </p> 
                @else
                   <p>{{{ $strippedBio }}} </p> 
                @endif
				</span>

				<span class="infolabel"><b>Classes:</b></span> </br>
				<span>
					@foreach(User::find($result->id)->courses as $course)
						@if (!empty($searchCourses))
							@foreach($searchCourses as $searchCourse)
								@if($course->id == $searchCourse->id)
									<span class="courselabelmatch">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
								@endif
							@endforeach 
						@endif
					@endforeach
					@foreach(User::find($result->id)->courses as $course)
						<?php $t = false ?>
						@if (!empty($searchCourses))
							@foreach($searchCourses as $searchCourse)
								@if($course->id == $searchCourse->id)
									<?php $t = true ?>
								@endif
							@endforeach 
						@endif
						@if(!$t)
							<span class="courselabel">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
						@endif
					@endforeach
				</span>
					
				</div>
			</div>
			
		</div>
		@endforeach
		@if(!empty($bioresults))
		</div>
		</div>
		@endif
	@endif
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	<script>
		$(document).ready(function() { 
		$(".select2-container").select2({
			placeholder: "Search for Users by Classes"
		});
		});
		/* Hide and show post divs on button press
		$('#search-title').click(function() {
			$('#new-post-body').toggle(200);
		});
		$('#hide-name-button').click(function() {
			$('#name-body').toggle(200);
		});
		$('#hide-bio-button').click(function() {
			$('#bio-body').toggle(200);
		});*/
	</script>
@stop