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
	</style>
@stop

@section('content')

	<!-- New post functionality -->
	<div id="new-post" class="panel panel-default">
	    <div class="panel-heading">
			<h4>
			New Post
			<div class="btn-group" id="new-post-buttons">
				<button id="hide-new-post-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
			</h4>
		</div>
	    
		<div id="new-post-body" class="panel-body">
			{{ Form::open(array('url' => 'creategeneralpost', 'method' => 'POST')) }}
			
			<div class="form-group">
				{{ Form::textarea('content', null, array('class' => 'form-control',
														 'placeholder' => 'Write post content here',
														 'rows' => '5')) }}
			</div>
					
			<div class="panel-footer code-collapse">
				Tags: 
				<select style="width:80%;" multiple id="tag-select" class="select2-container" name="hashtags[]" placeholder="Please select some tags for your post this is soggk">
					@foreach(Hashtag::all() as $tag)
						<option value={{{ $tag->id }}}>{{{ $tag->name }}}</option>
					@endforeach
				</select>
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
	
	<!-- Generate all recent user posts -->
	@foreach ($posts as $post)
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
	@endforeach
	
	<!-- Loading all scripts at the end for performance -->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	
	<script>

		// Hide and show post divs on button press
		$('#hide-new-post-button').click(function() {
			$('#new-post-body').toggle(200);
		});
		
		// Set up select2 menu (not currently working...)
		$(document).ready(function() { 
			$(".select2-container").select2();
		});

	</script>
@stop