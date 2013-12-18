@extends('common.master')

@section('content')
	@if ($post->postable_type == 'PostQuestion')
		<div>
			<h1>CS Interview Question of the Week</h1>
		</div>
	@else
    	<h1>Hello world</h1>
	@endif
	{{View::make('common.newsfeedPost')->with('post', $post)}}

	{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

	{{ Form::hidden('user_id', $user->id) }}

	{{ Form::hidden('post_id', $post->id) }}

	{{ Form::submit('Upvote', array('class' => 'btn btn-lg btn-primary btn-block')) }}

	{{ Form::close() }}

	@foreach ($post->comments as $comment)
		<div class="well">
			<div style="float:left; padding-right: 10px">
			@if (!empty($comment->user->picture))
				@if ( File::exists('assets/img/profile_images/' . $comment->user->picture ))
					{{ HTML::image('assets/img/profile_images/'.$comment->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70')) }}
				@else
					{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70')) }}
				@endif
			@else
				{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70')) }}
			@endif
			</div>
			<p>{{$comment->content}}</p>
			<p>Posted by {{$comment->user->first}} {{$comment->user->last}} at {{$comment->created_at}}</p>
		</div>
	@endforeach

	<div class="well">
		{{ Form::open(array('url' => 'createComment', 'method'=>'post')) }}

		{{ Form::textarea('content', 'hello world') }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('post_id', $post->id) }}

		{{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}

		{{ Form::close() }}
	</div>
@stop

@if ($post->postable_type == 'PostQuestion')
	@section('seeall')
		<hr>
		<li><a href="{{URL::to('showPreviousQuestions')}}">Show Previous Questions</a></li>
	@stop
@endif