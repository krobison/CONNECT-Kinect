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
		{{View::make('common.comment')->with('comment', $comment)}}
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
		<li><a href="{{URL::to('showPreviousQuestions')}}">Show Previous</a></li>
	@stop
@endif
