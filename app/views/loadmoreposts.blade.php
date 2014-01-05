


	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/jquery.stellar.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/posts.css') }}
	
	<!-- Generate all recent user posts -->
	<div id="postswrapper">
	@foreach ($posts as $postid)
		<?php 
		$post = Post::find($postid->id)
		?>
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
		<div class="postitem" id="{{$post->id}}"></div>
	@endforeach
	</div>
	
	
