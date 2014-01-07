@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('title')
	@if ($post->postable_type == 'PostQuestion')
		CS QUESTION.
	@else
		POST DETAILS.
	@endif
@stop

@section('content')
	@if ($post->postable_type == 'PostQuestion')
		<a style="float:right" href="{{ URL::to('showPreviousQuestions') }}"><span class="glyphicon glyphicon-arrow-left"></span>   Previous Questions</a>
		<h2>CS Question of the Week</h2>	
		<p>
			Give your answers and thoughts in the comments. A new question will be posted every week. The user who posts the best answer (as judged by CS Connect Administrator) will receive a small prize at the end of the week.
		</p>

		@if($user->admin == '1')
		<!-- New post functionality -->
		<div id="new-post" class="panel panel-default">
			<div class="panel-heading">
				<h4>
				New Post
				<div class="btn-group" id="new-post-buttons">
					<button id="hide-new-post-button" type="button" class="btn btn-default btn-sm">Hide</button>
				</div>
				</h4>
			</div>
			{{ View::make('common/createPost')->with('url', 'createcsquestionpost') }}
		</div>
	@endif
	
	@elseif ($post->postable_type == 'PostProject')
    	<h1>CS Project</h1>
	@elseif ($post->postable_type == 'PostHelpOffer')
		<h1>Help Offer</h1>
	@elseif ($post->postable_type == 'PostHelpRequest')
		<h1>Help Request</h1>
	@elseif ($post->postable_type == 'PostFeedback')
		<h1>Feedback</h1>
	@else
		<h1>Post Details</h1>
	@endif
	
	{{View::make('common.newsfeedPost')->with('post', $post)->with('detail','true')}}
	
	@if ($post->code != "")
		<div class="well">
			Language: {{ $post->language }}
			<div id="editor{{$post->id}}">
				{{{ $post->code }}}
			</div>
		</div>
		{{ HTML::script('assets/js/ace/ace.js') }}
		<script>
			// Setting up the ace text editor language
			var editor = ace.edit("editor{{$post->id}}");
			editor.getSession().setUseWorker(false);
			editor.setTheme("ace/theme/eclipse");
			var language = "{{$post->language}}";
			editor.getSession().setMode("ace/mode/" + language);
			editor.setReadOnly(true);
			editor.setOptions({
				maxLines: 50
			});
		</script>
	@endif
	@if ($post->postable_type == 'PostHelpOffer')
		{{--
		<div class="well">
			Availability:
			{{{ $post->postable->availability }}}
		</div>
		--}}
	@elseif ($post->postable_type == 'PostProject')
		<div class="well">
			<div class="row" style="text-align:center">
			@if($post->postable->file)
			<h3> {{ link_to('/assets/csproject_files/'.$post->postable->file, 'Download') }} </h3>
			@endif
			@if($post->postable->link)
			<h3> {{ link_to($post->postable->link, 'Link To Project') }} </h3>
			@endif
			</div>
			<div class="row" style="text-align:center">
			{{ HTML::image('assets/img/csproject_images/'.$post->postable->screenshot, 'CS Project Screenshot', array('width' => '512', 'height' => '512')) }}
			</div>
			<div class="row">
			@if ($post->postable->approved == '0' && Auth::user()->admin == '1')
				{{ Form::open(array('url' => 'approveproject', 'method'=>'post')) }}
				{{ Form::hidden('id', $post->id) }}
				<button type="submit" class="btn btn-success" style="float:right"  onclick="return confirm('Are you sure you would like to approve this project?');">
					<span class="glyphicon glyphicon-ok"></span> Approve Project
				</button>
				{{ Form::close() }}
			@endif
			</div>
		</div>
			
			
	@endif

	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.min.js') }}
	{{ HTML::script('assets/js/ace/ace.js') }}
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
					{{ HTML::image('assets/img/dummy.png', $user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
				@endif
			@endif 
		</div>

		{{ Form::textarea('content', null, array('class' => 'span4 form-control' ,'placeholder' => 'Enter your comment here','id' => 'comment-box')) }}

		{{ Form::hidden('user_id', $user->id) }}

		{{ Form::hidden('post_id', $post->id) }}

		<div id="code-panel" class="panel panel-default" style="background-color:transparent; border-style:none;">
			<div id="code-title" class="panel-body active">
				<a>Add code<a>
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor" type="hidden" name="code">
			</div>

			<div id="editor" class="code-collapse"> &#10 Select your language below. &#10 Then add your code here! &#10</div>
				
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
	
	@if($user->admin == '1')
		@if($post->postable_type != 'PostQuestion')
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
		{{ HTML::script('assets/js/select2.min.js') }}
		{{ HTML::script('assets/js/ace/ace.js') }}
		@endif
	@endif
	
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
		
		// Hide the add code section to start
		$('.code-collapse').hide();
		
		// Toggle add code div visibility
		$('#code-title').click(function() {
			$('.code-collapse').toggle();
			editor.resize();
		});
		
		// Set up select2 menu
		$(document).ready(function() { 
			$(".select2-container").select2();
		});
		
		// Hide and show post divs on button press
		$('#hide-new-post-button').click(function() {
			$('#new-post-body').toggle(200);
		});

	</script>
	
@stop


