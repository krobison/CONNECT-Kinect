@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style>
	h4 {
		margin:0px;
		padding:0px;
	}
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
			<h4>CS Projects</h4> 
		</div>
		<div id="cs-project" class="panel-body">
			Order Projects By: <button disabled type="button" class="btn btn-default" id="order-upvotes">Upvotes</button> <button type="button" class="btn btn-default" id="order-time">Time</button>
			<hr>
			<div id="postprojectswrapper" style="padding: 15px;" class="row">
			{{ View::make('loadmoreprojectposts')
					->with('user', Auth::user())
					->with('posts', $projectposts) }}
			</div>
			<div id="loadmoreprojectsbutton" style="text-align:center">
				<button type="button" class="btn btn-default">Load more...</button>
			</div>
		</div>

	</div>
	
	<!-- Loading all scripts at the end for performance-->
	<script>
	$(document).ready(function() {
		$("#link").keyup(function() {
			verifyFields();
		});
		$('#screenshot').bind('change', function() {
			verifyFields();
		});
		$("#zip").change(function() {
			verifyFields();
		});
		verifyFields();
	});
	var verifyFields = function() {
		var anythingWrong = false;
		var errors = '<div class="alert alert-danger">'
		// File Upload
		if($("#zip")[0].files[0]) {
			if($("#zip")[0].files[0].size > 2000000) {
				anythingWrong = true;
				errors = errors + "Uploaded zip file is too big<br>";
			}
			if($("#zip")[0].files[0].type.split('/')[0] != 'application'){
				anythingWrong = true;
				errors = errors + "Uploaded zip file is of the wrong file type<br>";
			}
		}
		if($("#zip").val().length == 0 && $("#link").val().length == 0) {
			anythingWrong = true;
			errors = errors + "You must upload a zip file or provide a link<br>";
		}
		
		// Screenshot
		if($("#screenshot")[0].files[0]) {
			if($("#screenshot")[0].files[0].size > 2000000) {
				anythingWrong = true;
				errors = errors + "Screenshot file is too big<br>";
			}
			if($("#screenshot")[0].files[0].type.split('/')[0] != 'image'){
				anythingWrong = true;
				errors = errors + "Screenshot file is not an image<br>";
			}
		}
		if($("#screenshot").val().length == 0) {
			anythingWrong = true;
			errors = errors + "Screenshot file must be uploaded<br>";
		}
		
		if(anythingWrong) {
			errors = errors + "</div>";
			$("#javascript_errors").html(errors);
			$("#submit-button").attr('disabled', true);
		} else {
			$("#javascript_errors").html( '<div class="alert alert-success"> All fields complete and verified </div>');
			$("#submit-button").attr('disabled', false);
		}
	}
	
	{{-- For Sorting Posts --}}
	var sort_type = 'upvotes';
	$('#order-time').click(function() {
		$('#order-time').attr('disabled',true);
		$('#order-upvotes').attr('disabled',false);
		//var postsLoaded = $(".PostProject").length;
		$("#postprojectswrapper").empty();
		morePosts(8,0,"id");
		sort_type = 'id';
	});
	$('#order-upvotes').click(function() {
		$('#order-upvotes').attr('disabled',true);
		$('#order-time').attr('disabled',false);
		//var postsLoaded = $(".PostProject").length;
		$("#postprojectswrapper").empty();
		morePosts(8,0,"upvotes");
		sort_type = 'upvotes';
	});
	order-time
	
	</script>
	<script>
		// Hide and show post divs on button press
		$('#hide-new-post-title').click(function() {
			$('#new-post-body').toggle(200);
		});
		
		$('#hide-approve-projects-button').click(function() {
			$('#approve-projects').toggle(200);
		});
		
		$(document).ready(function() {
			$('#new-post-body').hide();
		});
		
		var postsLoaded = $(".PostProject").length;
		$("#loadmoreprojectsbutton").click(function (){
            $('#loadmoreprojectsbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
			morePosts(4,postsLoaded,sort_type);
        });
			
		var morePosts = function(count,offset,sort) {
			$.ajax({
				url: '{{ URL::to("loadmoreprojects") }}',
				type: 'POST',
				data: {'lastpost':offset,'orderBy':sort,'toLoad':count},
				dataType: 'html',
				success: function(data){
					if(data){
						$("#postprojectswrapper").append(data);
						postsLoaded = $(".PostProject").length;
						$('#loadmoreprojectsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
					}else{
						$('#loadmoreprojectsbutton').html('<center>No more posts to show.</center>');
					}
				},
				timeout: 6000,
				error: function(x, t, m){ 
					$('#loadmoreprojectsbutton').html('<center>The request to load more posts is taking too long, please try again later.</center> <br> <button type="button" class="btn btn-default">Load more...</button>');
				}
			});
		}
	</script>
@stop