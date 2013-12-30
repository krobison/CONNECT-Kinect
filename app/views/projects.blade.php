@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/helpcenter.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style type="text/css" media="screen">
    #editor { 
		width: 100%;
		height: 100px;
    }
	#new-post-buttons {
		float: right;
	}
	hr {
		margin: 5px;
		padding: 1px%;
	}
	h3 {
		margin: 5px;
		padding: 1px%;
	}
	#code-title:hover {
		background-color: #F5F5F5;
	}
	.five-marg {
		margin: 5px;
	}
	</style>
@stop

@section('content')
	<h2>CS Projects</h2>
	<p>
		Check out all the projects that the mines community has been working on.
	</p>
	<div id="new-post" class="panel panel-default">
	    <div class="panel-heading">
		<h4>
			New Project Post
			<div class="btn-group" id="new-post-buttons">
				<button id="hide-new-post-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
		</h4>
		</div>
		
		<div id="new-post-body" class="panel-body">
			{{ Form::open(array('url' => 'createprojectpost', 'files' => true)) }}
			
			<div class="form-group">
				<b> Upload a .zip of your project. </b>
				{{Form::file('file', array())}}
			</div>
			<div class="form-group">
				<b> Post a link to your project. </b>
				<br>
				{{Form::url('link', null,array('placeholder' => 'http://exampleurl' ))}}
			</div>
			<div class="form-group">
				<b> Post a screenshot of your project. </b>
				{{Form::file('screenshot', array())}}
			</div>
			<div class="form-group">
				{{ Form::textarea('content', null, array('class' => 'form-control',
														 'placeholder' => 'Write post content here',
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
		<div id="help-request" class="panel-body">
			{{-- $post_counter = 0; --}}
			@foreach (Post::where('postable_type', '=', 'PostProject')->orderBy('id', 'DESC')->get() as $post)
				@if($post->postable->approved == '1')
					{{ View::make('common.newsfeedPost')->with('post', $post) }}
					{{-- $post_counter = $post_counter + 1 --}}
				@endif
			@endforeach
			
			{{-- @if( $post_counter >= 5 ) --}}
				<button type="button" class="btn btn-default">Load more... <i> Not Working </i> </button>
			{{-- @endif --}}
		</div>
	</div>
	
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	
	<script>
	// Hide and show post divs on button press
		$('#hide-new-post-button').click(function() {
			$('#new-post-body').toggle(200);
		});
		
		$('#hide-approve-projects-button').click(function() {
			$('#approve-projects').toggle(200);
		});
	</script>
@stop