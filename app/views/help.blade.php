@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	<style>
	.panel-heading:hover{ 
		background-color:orange;
	}
	</style>
@stop

@section('title')
	HELP CENTER.
@stop

@section('content')
	<h2>Help Center</h2>
	
	<div id="new-post" class="panel panel-default">
	    <div id="new-help-title" class="panel-heading">
			<h4>New Help Post<h4>
		</div>
		<div id="new-help-content">
			<div class="btn-toolbar five-marg" role="toolbar">
				<div class="btn-group">
					<button id="need-help-button" type="button" class="btn btn-default btn-sm">I Need Help</button>
					<button id="offer-help-button" type="button" class="btn btn-default btn-sm">I Want To Offer My Help</button>
				</div>
			</div>
			
			<div id="help-request" class="panel-body">
				{{ View::make('common/createPost')->with('url', 'createhelprequestpost') }}
			</div> 
			
			
			<div id="help-offer" class="panel-body">
				{{ Form::open(array('url' => 'createhelpofferpost')) }}
										
				<div class="form-group">
					{{ Form::textarea('content', null, array('class' => 'form-control',
															 'placeholder' => 'What do you want to help other people with? When are you Available?',
															 'rows' => '5')) }}
				</div>
				
				{{--
				<div class="form-group">
					{{ Form::textarea('availability', null, array('class' => 'form-control',
															 'placeholder' => 'When are you available to help?',
															 'rows' => '5')) }}
				</div>
				--}}
				
				<hr>
				
				<div class="row">
					<div class ="col-xs-5 col-md-4">
						{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>			
	</div>

	<div id="recent-help-requests" class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent Help Requests</h4>
		</div>
		<div id="help-request" class="panel-body">
			<div id="postrequestswrapper">
			@foreach (Post::where('postable_type', '=', 'PostHelpRequest')->take(5)->orderBy('id', 'DESC')->get() as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
				{{-- $post_counter = $post_counter + 1 --}}
			<div class="{{$post->postable_type}}" id="{{$post->id}}"></div>
			@endforeach
			</div>
			<div id="loadmorerequestsbutton">
				<button type="button" class="btn btn-default">Load more...</button>
			</div>
		</div>
	</div>
	
	<div id="recent-help-offers" class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent Help Offers</h4>
		</div>
		<div id="help-request" class="panel-body">
			<div id="postofferswrapper">
			@foreach (Post::where('postable_type', '=', 'PostHelpOffer')->take(5)->orderBy('id', 'DESC')->get() as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
			<div class="{{$post->postable_type}}" id="{{$post->id}}"></div>
			@endforeach
			</div>
			<div id="loadmoreoffersbutton">
				<button type="button" class="btn btn-default">Load more...</button>
			</div>
		</div>
	</div>
	
	<!-- Loading all scripts at the end for performance-->
	{{-- HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') --}}
	
	<script>
		
		$(document).ready(function(){
			// Start with new help post div's hidden
			$('#help-request').hide();
			$('#help-offer').hide();
			$('#new-help-content').hide();
		});
		
		// Hide and show post divs on button press
		$('#offer-help-button').click(function() {
			$('#help-request').hide(200);
			$('#help-offer').show(200);
			editor.resize();
		});
		$('#need-help-button').click(function() {
			$('#help-request').show(200);
			$('#help-offer').hide(200);
			editor.resize();
		});
		$('#new-help-title').click(function() {
			$('#new-help-content').toggle(200);
		});
		
		var requestID = $(".PostHelpRequest:last").attr("id");
		$("#loadmorerequestsbutton").click(function (){
               $('#loadmorerequestsbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
                $.ajax({
					url: '{{ URL::to('loadmorerequests') }}',
					type: 'POST',
                    data: 'lastpost='+requestID,
					dataType: 'html',
					success: function(data){
                        if(data){
                            $("#postrequestswrapper").append(data);
                            requestID = $(".PostHelpRequest:last").attr("id");
							 $('#loadmorerequestsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
                        }else{
                            $('#loadmorerequestsbutton').replaceWith('<center>No more posts to show.</center>');
                        }
                    }
					
                });
            });
			
		var offerID = $(".PostHelpOffer:last").attr("id");
		$("#loadmoreoffersbutton").click(function (){
               $('#loadmoreoffersbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
                $.ajax({
					url: '{{ URL::to('loadmoreoffers') }}',
					type: 'POST',
                    data: 'lastpost='+offerID,
					dataType: 'html',
					success: function(data){
                        if(data){
                            $("#postofferswrapper").append(data);
                            offerID = $(".PostHelpOffer:last").attr("id");
							$('#loadmoreoffersbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
                        }else{
                            $('#loadmoreoffersbutton').replaceWith('<center>No more posts to show.</center>');
                        }
                    }
					
                });
            });
		
	</script>
@stop