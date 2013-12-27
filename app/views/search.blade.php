@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/search.css') }}
@stop

@section('content')
	<h1> Search Page </h1>
	{{ Form::open(array('url' => 'searchfilter', 'method' => 'GET')) }}
	@if(!empty($name))
	{{ Form::text('name', $name, array( 'placeholder' => 'Search Users')) }}
	@else
	{{ Form::text('name', null, array( 'placeholder' => 'Search Users')) }}
	@endif
					<select multiple class="select2-container classSelect" name="classes[]">
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
				
	{{ Form::Submit('Search') }}
	{{ Form::close() }}
	
	<br>
	
	@if(isset($results))
		@foreach($results as $result) 
		<div class="well">
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
				<span>
					<h3><a href="{{URL::to('profile', $result->id)}}">{{{ $result->first }}} {{{ $result->last }}} </a></h3>
				</span>
			<span>

				<div>

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
					
					
				</div>
			</span>
			</div>
			
		</div>
		@endforeach
	@endif
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	<script>
		$(document).ready(function() { 
		$(".select2-container").select2({
			placeholder: "Select Your Classes"
		});
		});
	</script>
@stop