@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/helpcenter.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style type="text/css" media="screen">
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
	</style>
@stop

@section('content')
	<h2>Help Center</h2>

	<hr>
	
	<h4>New Help Post<h4>
	<div id="new-post" class="panel panel-default">
	    <div class="panel-heading">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group">
					<button id="need-help-button" type="button" class="btn btn-default">I Need Help</button>
					<button id="offer-help-button" type="button" class="btn btn-default">I Want To Offer My Help</button>
				</div>
				<div class="btn-group">
					<button id="hide-help-button" type="button" class="btn btn-default">Hide</button>
				</div>
			</div>
		</div>
	    
		<div id="help-request" class="panel-body">
			{{ Form::open(array('url' => 'createhelprequestpost')) }}
			
			<div class="form-group">
				<b> How would you like to recieve help? </b> <br>
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '1', array('checked' => 'true')) }}
					In the comments
				</label>
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '2') }}
					In person
				</label>
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '3') }}
					Skype/Hangouts/Video Chat
				</label>
			</div>
					
			<div class="form-group">
				<b> How would you like to be displayed? </b> <br>
				<label class="radio-inline">
				{{ Form::radio('anonymous', '0', array('checked' => 'true')) }}
					Post as {{ $user->first }} {{ $user->last }}
				</label>
				<label class="radio-inline">
				{{ Form::radio('anonymous', '1') }} 
					Post Anonymously
				</label>
			</div>
			
			<div class="form-group">
				{{ Form::textarea('content', null, array('class' => 'form-control',
														 'placeholder' => 'What do you need help with?',
														 'rows' => '5')) }}
			</div>
			
			<div id="code-panel" class="panel panel-default">
				<div id="code-title" class="panel-body active">
					Add code
				</div>
				
				<div id="hidden-editor_div">
					<input id="hidden-editor" type="hidden" name="code">
				</div>

				<div id="editor" class="panel panel-default code-collapse">
				
				Select your language below
				Then add your code here!
				
				</div>
					
				<div class="panel-footer code-collapse">
					Language: 
					<select id="language-select" class="select2-container" name="language">
						@foreach(Post::getSupportedLanguages() as $language)
							@if ($language === "plain_text")
								<option selected value={{ $language }}>{{ ucfirst($language) }}</option>
							@else
								<option value={{ $language }}>{{ ucfirst($language) }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			
			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
					{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
				</div>
			</div>
			{{ Form::close() }}
		</div> 
		
		<div id="help-offer" class="panel-body">
			{{ Form::open(array('url' => 'createhelpofferpost')) }}
									
			<div class="form-group">
				{{ Form::textarea('content', null, array('class' => 'form-control',
														 'placeholder' => 'What do you want to help other people with?',
														 'rows' => '5')) }}
			</div>

			<div class="form-group">
				{{ Form::textarea('availability', null, array('class' => 'form-control',
														 'placeholder' => 'When are you available to help?',
														 'rows' => '5')) }}
			</div>
			
			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
					{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
				</div>
			</div>
			{{ Form::close() }}
		</div>  	
	</div>

	<h4>Recent Help Requests</h4>
	
	{{-- $post_counter = 0; --}}
	@foreach (Post::where('postable_type', '=', 'PostHelpRequest')->take(5)->orderBy('id', 'DESC')->get() as $post)
		{{ View::make('common.newsfeedPost')->with('post', $post) }}
		{{-- $post_counter = $post_counter + 1 --}}
	@endforeach
	
	{{-- @if( $post_counter >= 5 ) --}}
		<button type="button" class="btn btn-default">Load more...</button>
	{{-- @endif --}}
	
	<h4>Recent Help Offers</h4>
	
	{{-- @$post_counter = 0; --}}
	@foreach (Post::where('postable_type', '=', 'PostHelpOffer')->take(5)->orderBy('id', 'DESC')->get() as $post)
		{{ View::make('common.newsfeedPost')->with('post', $post) }}
		{{-- $post_counter = $post_counter + 1 --}}
	@endforeach
	
	{{--@if( $post_counter >= 5 )--}}
		<button type="button" class="btn btn-default">Load more...</button>
	{{--@endif--}}
	
	<!-- Loading all scripts at the end for performance-->
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

			//$(".select2-container").select2();
		});
	</script>
@stop