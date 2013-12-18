<a href="{{URL::to('singlepost', $post->id)}}">

	@if ($post->postable_type == "PostHelpRequest")
	
		<div class="well">
			This is a PostHelpRequest post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<p> Upvote count: {{ $post->postupvotes->count() }} </p>

			{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

			{{ Form::hidden('user_id', Auth::user()->id) }}

			{{ Form::hidden('post_id', $post->id) }}

			<button type="submit" class="btn btn-primary">
				<i class="glyphicon glyphicon-hand-up"></i> Upvote
			</button>

			{{ Form::close() }}
			
			Langauge: {{$post->postable->language}}
		</div>

	@elseif ($post->postable_type == "PostHelpOffer")
	
		<div class="well">
			This is a PostHelpOffer post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>

			<p> Upvote count: {{ $post->postupvotes->count() }} </p>

			{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

			{{ Form::hidden('user_id', Auth::user()->id) }}

			{{ Form::hidden('post_id', $post->id) }}

			<button type="submit" class="btn btn-primary">
				<i class="glyphicon glyphicon-hand-up"></i> Upvote
			</button>

			{{ Form::close() }}
			
		</div>

	@elseif ($post->postable_type == "PostQuestion")

		<div class="well">
			<p> {{ $post->content }} </p>
			
			<p> Sponsored by {{ $post->postable->company_sponser }} </p>

			<p> Upvote count: {{ $post->postupvotes->count() }} </p>

			{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

			{{ Form::hidden('user_id', Auth::user()->id) }}

			{{ Form::hidden('post_id', $post->id) }}

			<button type="submit" class="btn btn-primary">
				<i class="glyphicon glyphicon-hand-up"></i> Upvote
			</button>

			{{ Form::close() }}
			
		</div>
		
	@else
	
		<div class="well">
			This is a Unspecified post!
			<p> {{ $post->content }} </p>
			<p> Posted by {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>
			
			<p> Upvote count: {{ $post->postupvotes->count() }} </p>

			{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

			{{ Form::hidden('user_id', Auth::user()->id) }}

			{{ Form::hidden('post_id', $post->id) }}

			<button type="submit" class="btn btn-primary">
				<i class="glyphicon glyphicon-hand-up"></i> Upvote
			</button>

			{{ Form::close() }}
			
		</div>
		
	@endif
	
</a>
