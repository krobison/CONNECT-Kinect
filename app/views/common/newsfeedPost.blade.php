<a href="{{URL::to('singlepost', $post->id)}}">
	<div class="well">
		<p> {{ $post->content }} </p>
		<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>
	</div>
</a>
