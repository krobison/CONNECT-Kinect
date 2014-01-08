@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style>
	#hide-new-post-title:hover{ 
		background-color:orange;
	}
	.first-on-page{
		margin-top:5px;
	}
	</style>
@stop

@section('title')
	CS PROJECTS.
@stop

@section('content')
	<h2>CS Projects</h2>
	<p>
		Check out all the projects that the Mines community has been working on.
	</p>
	<div id="new-post" class="panel panel-default">
	    <div id="hide-new-post-title" class="panel-heading">
		<?php $message = Session::get('message');?>
			{{$message}}
			<h4> New Project Post </h4>	
			<p>
				Upload your project here. Provide a link to your project (web site, github, public dropbox, etc...), upload a zip file of your project, or both! Also, please include a screenshot and a description of your project as well. Posts will be evaluated and approved by a Connect administrator then posted on the CS Projects page. Note: the screenshot and zip file combine must be less than 2Mb.
			</p>
		</div>
		{{ View::make('common/createPost')->with('url', 'createprojectpost') }}
	</div>
	
	@if($user->admin == '1')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Projects That Need Approval
			<div class="btn-group" id="new-post-buttons">
				<button id="hide-approve-projects-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
			</h4>
		</div>
		<div id="approve-projects" class="panel-body">
			{{-- $post_counter = 0; --}}
			@foreach (Post::where('postable_type', '=', 'PostProject')->orderBy('id', 'DESC')->get() as $post)
				@if($post->postable->approved == '0')
					{{ View::make('common.newsfeedPost')->with('post', $post) }}
					{{-- $post_counter = $post_counter + 1 --}}
				@endif
			@endforeach
			
			{{-- @if( $post_counter >= 5 ) --}}
				<button type="button" class="btn btn-default">Load more... <i> Not Working </i> </button>
			{{-- @endif --}}
		</div>
	</div>
	@endif
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent CS Projects</h4>
		</div>
		<div id="cs-project" class="panel-body">
			<div id="postprojectswrapper">
			@foreach ($projectposts as $postid)
				<?php 
				$postp = Post::find($postid->id);
				?>
			{{ View::make('common.newsfeedPost')->with('post', $postp) }}
			<div class="{{$postp->postable_type}}" id="{{$postp->id}}"></div>
			@endforeach
			</div>
			<div id="loadmoreprojectsbutton">
				<button type="button" class="btn btn-default">Load more...</button>
			</div>
		</div>
	</div>
	
	<!-- Loading all scripts at the end for performance-->
	<script>
		// Hide and show post divs on button press
		$('#hide-new-post-title').click(function() {
			$('#new-post-body').toggle(200);
		});
		$('#new-post-body').hide();
		
		$('#hide-approve-projects-button').click(function() {
			$('#approve-projects').toggle(200);
		});
		
		var projectID = $(".PostProject:last").attr("id");
		$("#loadmoreprojectsbutton").click(function (){
               $('#loadmoreprojectsbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
                $.ajax({
					url: '{{ URL::to('loadmoreprojects') }}',
					type: 'POST',
                    data: 'lastpost='+projectID,
					dataType: 'html',
					success: function(data){
                        if(data){
                            $("#postprojectswrapper").append(data);
                            requestID = $(".PostProject:last").attr("id");
							 $('#loadmoreprojectsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
                        }else{
                            $('#loadmoreprojectsbutton').replaceWith('<center>No more posts to show.</center>');
                        }
                    }
					
                });
            });
	</script>
@stop