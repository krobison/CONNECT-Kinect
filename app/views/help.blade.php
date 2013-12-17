@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/helpcenter.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style type="text/css" media="screen">
    #editor { 
		width: 100%;
		height: 100px;
    }
	</style>
@stop

@section('content')
	<div class="newpost">
	    
	    <h3>New Help Post</h3>
	    
	    <hr>
	    
	    {{ Form::open(array('url' => 'createhelppost')) }}
	    
	    <div class="form-group">
	    	<label class="radio-inline">
	    	{{ Form::radio('help_request', '1') }} 
	    		Help Request
	    	</label>
	    	<label class="radio-inline">
	    	{{ Form::radio('help_request', '0') }}
	    		Help Offer
	    	</label>
	    </div>
	    
	    <hr>
	    
	    <div class="form-group">
	    
	    	<label class="checkbox-inline">
	    	{{ Form::checkbox('help_type[]', '1') }}
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
	    
	    <hr>
	    
	    <div class="form-group">
	    	<label class="radio-inline">
	    	{{ Form::radio('anonymous', '1') }} 
	    		Post Anonymously
	    	</label>
	    	<label class="radio-inline">
	    	{{ Form::radio('anonymous', '0') }}
	    		Post as Yourself
	    	</label>
	    </div>
	    
	    <hr>
	    
	    <div class="form-group">
	   		{{ Form::textarea('content', null, array('class' => 'form-control',
													 'placeholder' => 'What do you need help with?',
													 'rows' => '5')) }}
	    </div>
		
		<div id = "code-bloc">
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
			<div id="editor" name="code">
				function foo(items) {
					var x = "All this is syntax highlighted";
					return x;
				}
			</div>
		</div>
   
	    <hr>
		
	    <div class="row">
	    	<div class ="col-xs-5 col-md-4">
	    	{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
	    	</div>
	    </div>
	    	    	
	</div>
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	{{ HTML::script('assets/js/ace/ace.js') }}
	
	<script>
		var editor = ace.edit("editor");
		editor.getSession().setUseWorker(false);
		editor.setTheme("ace/theme/eclipse");
		editor.getSession().setMode("ace/mode/plain_text");
		editor.setOptions({
			maxLines: 50
		});
		//editor.setReadOnly(true);
		$('#language-select').change(function() {
			editor.getSession().setMode("ace/mode/" + $('#language-select').val());
		});
		$(document).ready(function() { 
			$(".select2-container").select2();
		});
	</script>
@stop