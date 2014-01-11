	<!-- Generate all recent user posts -->
	
	@foreach ($posts as $postid)
		<?php 
		$post = Post::find($postid->id)
		?>
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
		<div class="postitem" id="{{$post->id}}"></div>
	@endforeach
	
	
	
