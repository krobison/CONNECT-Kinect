@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
@stop

@section('title')
	PROFILE.
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
				@if ($user->admin == '1' && $currentuser != $user)
					<form class="form-horizontal" role="form" action="{{ URL::to('deleteuser') }}" method="post">
						{{ Form::hidden('id', $currentuser->id) }}
						<button type="submit" class="btn btn-danger btn editbutton" onclick="return confirm('Are you sure you would like to delete this account FOREVER? This includes deletion of all posts, comments, and up-votes as well as uploaded projects and pictures.');">
							<span class="glyphicon glyphicon-trash"></span> Delete Account
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
			@if (!empty($userTags))
				<div class="courses">
					<h3>Tags</h3>
					@foreach ($userTags as $tags)
						<span class="courselabel">{{{$tags->name}}}</span>
					@endforeach
				</div>
			@endif
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
		<span class="infolabel"> <h3>Bio</h3></span><br>
	   {{$currentuser->bio}} 	
	</div>
	
	
	<div class="feed">
		<span class="infolabel"><h3>User Posts</h3></span>
		<div id="postswrapper">	
			@foreach ($posts as $postid)
				<?php 
				$post = Post::find($postid->id)
				?>
				@if ($post->postable_type != "PostHelpRequest" || $post->postable->anonymous != 1)
					{{ View::make('common.newsfeedPost')->with('post', $post) }}
				@endif
			<div class="postitem" id="{{$post->id}}"></div>
			@endforeach
		</div>
		<div id="loadmorebutton">
			<button type="button" class="btn btn-default">Load more...</button>
		</div>
	</div>
	
	<!-- Loading all scripts at the end for performance-->
	<script>
		var ID = $(".postitem:last").attr("id");
		var currentuserid = "<?php echo $currentuser->id ?>";
		$("#loadmorebutton").click(function (){
		    $('#loadmorebutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
			$.ajax({
				url: '{{ URL::to('loadmoreuserposts') }}',
				type: 'POST',
				data: 'lastpost='+ID+'&user_id='+currentuserid,
				dataType: 'html',
				success: function(data){
					if(data){
						$("#postswrapper").append(data);
						ID = $(".postitem:last").attr("id");
						$('#loadmorebutton').html('<button type="button" class="btn btn-default">Load more...</button>');
						bindUpvoteListener();
					}else{
						$('#loadmorebutton').replaceWith('<center>No more posts to show.</center>');
					}
				}
				
			});
		});
	</script>
@stop