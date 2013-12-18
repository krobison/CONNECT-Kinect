<a href="{{URL::to('singlepost', $post->id)}}">

	<div class="well">
		<p> {{ $post->content }} </p>
		<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

		<a href="{{Request::url()}}">
			{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
		</a>

		<p> Upvote count: {{ $post->postupvotes->count() }} </p>
		
	</div>
</a>
