@extends('common.master')

@section('content')
	<h1>Hello world</h1>
	{{View::make('common.newsfeedPost')->with('post', $post)}}

	{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

	{{ Form::hidden('user_id', $user->id) }}

	{{ Form::hidden('post_id', $post->id) }}

	{{ Form::submit('Upvote', array('class' => 'btn btn-lg btn-primary btn-block')) }}

	<div class="well">
		@foreach ($post->comments as $comment)
			<p>{{$comment->content}}</p>
			<p>Posted by {{$comment->user->first}} {{$comment->user->last}} at {{$comment->created_at}}</p>
		@endforeach
	</div>

	<div class="well">
		{{ Form::open(array('url' => 'createComment', 'method'=>'post')) }}

		{{ Form::textarea('content', 'hello world') }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('post_id', $post->id) }}

		{{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}
	</div>
@stop