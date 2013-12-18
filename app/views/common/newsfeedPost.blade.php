<div class="well">
	<a href="{{URL::to('singlepost', $post->id)}}">
		<p> {{ $post->content }} </p>
		<p> Posted by {{ $post->user->first }} {{ $post->user->last }} at {{ $post->created_at }} </p>
	</a>

	<p> Upvote count: {{ $post->postupvotes->count() }} </p>

	<!-- <span class="glyphicon glyphicon-hand-up"></span> -->

	{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

	{{ Form::hidden('user_id', Auth::user()->id) }}

	{{ Form::hidden('post_id', $post->id) }}

	<button type="submit" class="btn btn-primary">
		<i class="glyphicon glyphicon-hand-up"></i> Upvote
	</button>

	{{ Form::close() }}
	
</div>
