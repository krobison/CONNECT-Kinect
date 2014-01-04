@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('title')
	HELP CENTER.
@stop

@section('content')
	<h2>Help Center</h2>
	
	<div id="new-post" class="panel panel-default">
	    <div class="panel-heading">
			<h4>New Help Post<h4>
		</div>
		
		<div class="btn-toolbar five-marg" role="toolbar">
			<div class="btn-group">
				<button id="need-help-button" type="button" class="btn btn-default btn-sm">I Need Help</button>
				<button id="offer-help-button" type="button" class="btn btn-default btn-sm">I Want To Offer My Help</button>
			</div>
			<div class="btn-group">
				<button id="hide-help-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
		</div>
	    
		<div id="help-request" class="panel-body">
			{{ View::make('common/createPost')->with('url', 'createhelprequestpost') }}
		</div> 
		
		
		<div id="help-offer" class="panel-body">
			{{ Form::open(array('url' => 'createhelpofferpost')) }}
									
			<div class="form-group">
				{{ Form::textarea('content', null, array('class' => 'form-control',
														 'placeholder' => 'What do you want to help other people with?',
														 'rows' => '5')) }}
			</div>

			<div class="form-group">
				{{ Form::textarea('availability', null, array('class' => 'form-control',
														 'placeholder' => 'When are you available to help?',
														 'rows' => '5')) }}
			</div>
			
			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
					{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
				</div>
			</div>
			{{ Form::close() }}
		</div>  	
	</div>

	<div id="recent-help-requests" class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent Help Requests</h4>
		</div>
		<div id="help-request" class="panel-body">
			{{-- $post_counter = 0; --}}
			@foreach (Post::where('postable_type', '=', 'PostHelpRequest')->take(5)->orderBy('id', 'DESC')->get() as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
				{{-- $post_counter = $post_counter + 1 --}}
			@endforeach
			
			{{-- @if( $post_counter >= 5 ) --}}
				<button type="button" class="btn btn-default">Load more... <i> Not Working </i> </button>
			{{-- @endif --}}
		</div>
	</div>
	
	<div id="recent-help-offers" class="panel panel-default">
		<div class="panel-heading">
			<h4>Recent Help Offers</h4>
		</div>
		<div id="help-request" class="panel-body">
			{{-- @$post_counter = 0; --}}
			@foreach (Post::where('postable_type', '=', 'PostHelpOffer')->take(5)->orderBy('id', 'DESC')->get() as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
				{{-- $post_counter = $post_counter + 1 --}}
			@endforeach
			
			{{--@if( $post_counter >= 5 )--}}
				<button type="button" class="btn btn-default">Load more... <i> Not Working </i></button>
			{{--@endif--}}
		</div>
	</div>
	
	<!-- Loading all scripts at the end for performance-->
	{{-- HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') --}}
	
	<script>
		
		$(document).ready(function(){
			// Start with new help post div's hidden
			$('#help-request').hide();
			$('#help-offer').hide();
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
		$('#hide-help-button').click(function() {
			$('#help-request').hide(200);
			$('#help-offer').hide(200);
		});
		
	</script>
@stop