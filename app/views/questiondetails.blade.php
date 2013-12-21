@extends('common.master')

@section('content')
	<h1>Hello world</h1>
	{{View::make('common.csQuestionDetails')->with('question', $question)}}

	<div class="well">
		@foreach ($question->comments as $comment)
			<p>{{$comment->content}}</p>
			<p>Posted by {{$comment->user->first}} {{$comment->user->last}} at {{$comment->created_at}}</p>
		@endforeach
	</div>
This is the questiondetails
	<div class="well">
		{{ Form::open(array('url' => 'createCommentQuestion', 'method'=>'post')) }}

		{{ Form::textarea('content', null, array('placeholder' => 'Enter your comments here') }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('question_id', $question->id) }}

		{{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}
	</div>
@stop