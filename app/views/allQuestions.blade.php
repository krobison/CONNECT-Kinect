@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/posts.css') }}
	<style>
	.panel-heading:hover{ 
		background-color:orange;
	}
	.first-on-page{
		margin-top:5px;
	}
	hr {
		margin:0px;
		padding:0px;
	}
	h4 {
		margin:0px;
		padding:0px;
	}
	</style>
@stop

@section('title')
	ALL CS QUESTIONS.
@stop

@section('content')

	<div id="messages">
		{{Session::get('message');}}
	</div>
	
	<!-- Generate all recent user posts -->
	<div id="postswrapper">
	@foreach ($posts as $postid)
		<?php 
		$post = Post::find($postid->id)
		?>
		<h3> {{ date_format($post->created_at, 'l F jS Y \a\t g:ia') }}</h3>
		{{ View::make('common.newsfeedPost')->with('post', $post) }}
		<div class="postitem" id="{{$post->id}}"></div>
	@endforeach
	</div>
	</br>

@stop