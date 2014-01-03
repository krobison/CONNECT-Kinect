@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
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
	    {{ View::make('common/createPost')->with('url', 'creategeneralpost') }}
	</div>
	
	<!-- Generate all recent user posts -->
	@foreach ($posts as $post)
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
	@endforeach
	
	<!-- Loading all scripts at the end for performance -->
	<script>

		// Hide and show post divs on button press
		$('#hide-new-post-button').click(function() {
			$('#new-post-body').toggle(200);
		});

	</script>
@stop