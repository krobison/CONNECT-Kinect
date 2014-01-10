
@foreach ($posts as $postid)
	<?php 
	$post = Post::find($postid->id)
	?>
	@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
		<a href="{{URL::to('singlepost', $post->id)}}">
			<div class="image {{$post->postable_type}}" id="{{$post->id}}">
				<span class="overlap">{{{ substr($post->content, 0, 15) . '...'}}}<br>Upvotes: {{ $post->upvotes }}</span> <br>
				{{ HTML::image($post->getProjectImagePath(), 'CS Project Screenshot', array('style' => 'display: block', 'width' => '150', 'height' => '150')) }}
			</div>
		</a>
	@endif
	<div class="{{$post->postable_type}}" id="{{$post->id}}"></div>
@endforeach