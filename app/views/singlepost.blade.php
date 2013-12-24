@extends('common.master')

@section('additionalHeaders')
	<style>
	#comment-box {
		float:left;
		width:84%;
		height:60px;
		margin:10px;
	}
	</style>
@stop

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
				{{{ $post->postable->code }}}
			</div>
		</div>
		{{ HTML::script('assets/js/ace/ace.js') }}
		<script>
			// Setting up the ace text editor language
			var editor = ace.edit("editor{{$post->id}}");
			editor.getSession().setUseWorker(false);
			editor.setTheme("ace/theme/eclipse");
			var language = "{{$post->postable->language}}";
			editor.getSession().setMode("ace/mode/" + language);
			editor.setReadOnly(true);
			editor.setOptions({
				maxLines: 50
			});
		</script>
	@elseif ($post->postable_type == 'PostHelpOffer')
		<div class="well">
			Availability:
			{{ $post->postable->availability }}
		</div>
	@endif

	@foreach ($post->comments as $comment)
		{{ View::make('common.comment')->with('comment', $comment) }}
	@endforeach

	<div class="well">
		{{ Form::open(array('url' => 'createComment', 'method'=>'post')) }}
		
		<div style="float:left; padding-right: 10px">
			@if(is_null(Auth::user()->picture))
				{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
			@else
				{{ HTML::image('assets/img/profile_images/'.Auth::user()->picture, 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
			@endif 
		</div>

		{{ Form::textarea('content', null, array('class' => 'span4' ,'placeholder' => 'Enter your comment here','id' => 'comment-box')) }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('post_id', $post->id) }}

		{{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}

		{{ Form::close() }}
	</div>
	
	@if ($post->postable_type == 'PostQuestion')
		@section('seeall')
			<hr>
			<li><a href="{{URL::to('showPreviousQuestions')}}">Show Previous</a></li>
		@stop
	@endif
	
@stop


