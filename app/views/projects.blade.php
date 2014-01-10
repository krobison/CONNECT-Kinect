@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style>
	#hide-new-post-title:hover{ 
		background-color:orange;
	}
	
	.image { 
		position: relative; 
		float: left;
		margin: 8px;
		display: block;
		line-height: 0;
		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
	}
	
	.image:hover {
		-webkit-box-shadow: 0px 0px 20px rgba(53,152,219,0.8);
		-moz-box-shadow: 0px 0px 20px rgba(53,152,219,0.8);
		box-shadow: 0px 0px 20px rgba(53,152,219,0.8);
	}

	.overlap { 
	    position: absolute;
		top: 104px; 
		color: white; 
		font: bold 12px/13px Helvetica, Sans-Serif; 
		letter-spacing: 0px;  
		background: rgb(0, 0, 0); /* fallback color */
		background: rgba(0, 0, 0, 0.7);
		padding: 10px;
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
			@foreach (Post::where('postable_type', '=', 'PostProject')->orderBy('id', 'DESC')->get() as $post)
				@if($post->postable->approved == '0')
					{{ View::make('common.newsfeedPost')->with('post', $post) }}
				@endif
			@endforeach
			
			<button type="button" class="btn btn-default">Load more... <i> Not Working </i> </button>
		</div>
	</div>
	@endif
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent CS Projects</h4>
		</div>
		<div id="cs-project" class="panel-body">
			<div id="postprojectswrapper" style="padding: 15px;" class="row">
			@foreach ($projectposts as $postid)
				<?php 
				$postp = Post::find($postid->id);
				?>
				{{-- View::make('common.newsfeedPost')->with('post', $postp) --}}
				{{--<div class="{{$postp->postable_type}}" id="{{$postp->id}}"></div>--}}
				<a href="{{URL::to('singlepost', $postp->id)}}">
					<div class="image {{$postp->postable_type}}" id="{{$postp->id}}">
						<span class="overlap">{{{ substr($postp->content, 0, 15) . '...'}}}<br>Upvotes: {{ $postp->upvotes }}</span> <br>
						{{ HTML::image($postp->getProjectImagePath(), 'CS Project Screenshot', array('style' => 'display: block', 'width' => '150', 'height' => '150')) }}
					</div>
				</a>
			@endforeach
			</div>
			<div id="loadmoreprojectsbutton" style="text-align:center">
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
                            projectID = $(".PostProject:last").attr("id");
							$('#loadmoreprojectsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
                        }else{
                            $('#loadmoreprojectsbutton').replaceWith('<center>No more posts to show.</center>');
                        }
                    }
					
                });
            });
	</script>
@stop