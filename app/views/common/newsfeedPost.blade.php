<a href="{{URL::to('singlepost', $post->id)}}">

<<<<<<< HEAD
	@if ($post->postable_type == "PostHelpRequest")
		<div class="well">
			This is a PostHelpRequest post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
			
			<p> Upvote count: {{ $post->postupvotes->count() }} </p>
			
			Langauge: {{$post->postable->language}}
		</div>

	@elseif ($post->postable_type == "PostHelpOffer")
		<div class="well">
			This is a PostHelpOffer post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
			
			<p> Upvote count: {{ $post->postupvotes->count() }} </p>
			
		</div>
	@else
		<div class="well">
			This is a Unspecified post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<a href="{{Request::url()}}">
				{{ HTML::image('assets/img/upvote.png', 'upvote', array('width' => '22', 'height' => '22')) }}
			</a>
			
			<p> Upvote count: {{ $post->postupvotes->count() }} </p>
			
		</div>
	@endif
</a>
