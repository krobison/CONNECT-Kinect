@extends('common.master')

@section('content')
	@foreach ($posts as $post)
		{{ View::make('common.newsfeedPost')->with('post', $post) }}
	@endforeach
@stop