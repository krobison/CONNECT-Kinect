@extends('common.master')

@section('additionalHeaders')
	<style type="text/css" media="screen">
	{{ HTML::style('assets/css/select2.css') }}
	#comment-box {
		float:left;
		width:84%;
		height:60px;
		margin:10px;
	}
	#editor { 
		width: 100%;
		height: 100px;
    }
	hr {
		margin: 5px;
		padding: 1px%;
	}
	h3 {
		margin: 5px;
		padding: 1px%;
	}
	#code-title:hover {
		background-color: #F5F5F5;
	}
	.five-marg {
		margin: 5px;
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
				@if ( File::exists('assets/img/profile_images/' . Auth::user()->picture ))
					{{ HTML::image('assets/img/profile_images/'.Auth::user()->picture, 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
				@else
					{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
				@endif
			@endif 
		</div>

		{{ Form::textarea('content', null, array('class' => 'span4' ,'placeholder' => 'Enter your comment here','id' => 'comment-box')) }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('post_id', $post->id) }}

		<div id="code-panel" class="panel panel-default">
			<div id="code-title" class="panel-body active">
				Add code
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor" type="hidden" name="code">
			</div>

			<div id="editor" class="code-collapse">
			
			Select your language below
			Then add your code here!
			
			</div>
				
			<div class="panel-footer code-collapse">
				Language: 
				<select id="language-select" class="select2-container" name="language">
					@foreach(Post::getSupportedLanguages() as $language)
						@if ($language === "plain_text")
							<option selected value={{{ $language }}}>{{{ ucfirst($language) }}}</option>
						@else
							<option value={{ $language }}>{{{ ucfirst($language) }}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		{{ Form::submit('Comment', array('class' => 'btn btn-lg btn-primary btn-block')) }}

		{{ Form::close() }}
	</div>
	
	@if ($post->postable_type == 'PostQuestion')
		@section('seeall')
			<br>
			<a href="{{ URL::to('showPreviousQuestions') }}" class="list-group-item"><span class="glyphicon glyphicon-arrow-left"></span>   Previous Questions</a>
		@stop
	@endif

	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	{{ HTML::script('assets/js/ace/ace.js') }}
	
	<script>
		// Setting up the ace text editor
		var editor = ace.edit("editor");
		editor.getSession().setUseWorker(false);
		editor.setTheme("ace/theme/eclipse");
		editor.getSession().setMode("ace/mode/plain_text");
		//editor.setReadOnly(true);
		editor.setOptions({
			maxLines: 50
		});

		// Every time the content of the editor changes, update the value of the hidden form field to match
		editor.getSession().on('change', function(){
			var code = editor.getSession().getValue();
			$('#hidden-editor').val(code);
		});
		
		// Set Ace editor language based on language select form element
		$('#language-select').change(function() {
			editor.getSession().setMode("ace/mode/" + $('#language-select').val());
		});
		
		// Start with new help post div's hidden
		$('#help-request').hide();
		$('#help-offer').hide();
		$('.code-collapse').hide();

		// Hide and show post divs on button press
		$('#offer-help-button').click(function() {
			$('#help-request').hide(200);
			$('#help-offer').show(200);
			editor.resize();
		});
		$('#need-help-button').click(function() {
			$('#help-request').show(200);
			$('#help-offer').hide(200);
			editor.resize();
		});
		$('#hide-help-button').click(function() {
			$('#help-request').hide(200);
			$('#help-offer').hide(200);
		});
		
		// Button for showing code
		$('#code-title').click(function() {
			$('.code-collapse').toggle(200);
			editor.resize();
		});
		
		// Set up select2 menu (not currently working...)
		$(document).ready(function() { 

		$(".select2-container").select2();
		});
	</script>
	
@stop

