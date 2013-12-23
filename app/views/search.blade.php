@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('content')
	<h1> Search Page </h1>
	{{ Form::open(array('url' => 'searchfilter', 'method' => 'GET')) }}
	{{ Form::text('name', null, array( 'placeholder' => 'Search Users')) }}
	
					<select multiple class="select2-container classSelect" name="classes[]">
						<optgroup label="Computer Science">
							@foreach(Course::all() as $course)
								<option value={{ $course->id }}>{{ $course->prefix }}{{ $course->number }} - {{ $course->name }}</option>
							@endforeach
						</optgroup>
					</select>
				
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
			<span> {{{ $result->first }}} {{{ $result->last }}} </span>
		</div>
		</a>
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