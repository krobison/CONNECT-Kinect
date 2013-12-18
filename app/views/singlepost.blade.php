@extends('common.master')

@section('content')
	@if ($post->postable_type == 'PostQuestion')
		<h1>CS Question of the Week</h1>
	@elseif ($post->postable_type == 'PostProject')
    	<h1>CS Project</h1>
	@elseif ($post->postable_type == 'PostHelpOffer')
		<h1>Help Offer</h1>
	@elseif ($post->postable_type == 'PostHelpRequest')
		<h1>Help Request</h1>
	@else
		<h1>Post Details</h1>
	@endif
	{{View::make('common.newsfeedPost')->with('post', $post)}}
	
	@if ($post->postable_type == 'PostHelpRequest' && $post->postable->code != "")
		<div class="well">
			Language: {{ $post->postable->language }}
			<div id="editor{{$post->id}}">
				{{ $post->postable->code }}
			</div>
		</div>
	@elseif ($post->postable_type == 'PostHelpOffer')
		<div class="well">
			Availability:
			{{ $post->postable->availability }}
		</div>
	@endif

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

		{{ Form::close() }}
	</div>
	
	{{ HTML::script('assets/js/ace/ace.js') }}
	<script>
		// Setting up the ace text editor language
		var editor = ace.edit("editor{{$post->id}}");
		editor.getSession().setUseWorker(false);
		editor.setTheme("ace/theme/eclipse");
		var language = "{{$post->postable->language}}";
		//var language = "java";
		editor.getSession().setMode("ace/mode/" + language);
		editor.setReadOnly(true);
		editor.setOptions({
			maxLines: 50
		});
	</script>
@stop