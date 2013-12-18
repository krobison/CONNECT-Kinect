<a href="{{URL::to('singlepost', $post->id)}}">

	@if ($post->postable_type == "PostHelpRequest")
		<div class="well">
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
			Langauge: {{$post->postable->language}}
		</div>

	@elseif ($post->postable_type == "PostHelpOffer")
		<div class="well">
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
		</div>
	@else
		<div class="well">
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
		</div>
	@endif
	

</a>
