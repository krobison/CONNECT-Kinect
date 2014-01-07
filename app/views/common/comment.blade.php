<script>
   	@include('javascript.comment')
</script>
<style type="text/css" media="screen">
	#code-title{{$comment->id}}:hover {
		background-color: #F5F5F5;
	}
	.five-marg {
		margin: 5px;
	}
</style>

@if(Auth::user()->id == $comment->user_id)
	<div style="margin-bottom:16px;padding:8px;padding-bottom:32px;border:1px #CCCCCC solid;border-radius:20px;background-color:rgba(34,98,230,0.1)">  
@else
	<div style="margin-bottom:16px;padding:8px;padding-bottom:0px;border:1px #CCCCCC solid;border-radius:20px;background-color:rgba(34,98,230,0.1)">  
@endif	
	<div style="float:left; padding-right: 10px">
		{{HTML::image($comment->user->getProfilePictureURL(), '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle'))}}
	</div>
	
	<div>
		<p id="paragraph{{$comment->id}}" style="white-space:pre-wrap">{{ $comment->getPurifiedContent() }}</p>
	</div>

	{{Form::open()}}
	{{ Form::hidden('revertCode'.$comment->id, $comment->code) }}
	{{ Form::hidden('revertContent'.$comment->id, $comment->content) }}
	{{Form::close()}}

	@if (!empty($comment->code))
		<div>
			Language: {{{ $comment->language }}}
			<div id="editor{{$comment->id}}">
			</div>
		<script>
			// Setting up the ace text editor language
			$( document ).ready(function() {
				var editor = ace.edit("editor{{$comment->id}}");
				editor.setValue($('[name="revertCode{{$comment->id}}"]').val().trim());
				editor.getSession().setUseWorker(false);
				editor.setTheme("ace/theme/eclipse");
				var language = "{{$comment->language}}";
				editor.getSession().setMode("ace/mode/" + language);
				editor.setReadOnly(true);
				editor.setOptions({
					maxLines: 50
				});
			});
		</script>
		</div>
	@else
		<div id="code-panel{{$comment->id}}" class="panel panel-default" style="background-color:transparent; border-style:none;">
			<div id="code-title{{$comment->id}}" class="panel-body active">
				<a id="addCode{{$comment->id}}">Add code</a>
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor{{$comment->id}}" type="hidden" name="code{{$comment->id}}">
			</div>

			<div id="editor{{$comment->id}}" class="code-collapse{{$comment->id}}" style="width:100%; height:100px"> &#10 Select your language below. &#10 Then add your code here! &#10</div>
				
			<div class="panel-footer code-collapse{{$comment->id}}">
				Language: 
				<select id="language-select{{$comment->id}}" class="select2-container{{$comment->id}}" name="language{{$comment->id}}">
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
		
		<script>
			$( document ).ready(function() {
    			// Setting up the ace text editor language
				var editor = ace.edit("editor{{$comment->id}}");
				editor.getSession().setUseWorker(false);
				editor.setTheme("ace/theme/eclipse");
				editor.getSession().setMode("ace/mode/plain_text");
				editor.setOptions({
					maxLines: 50
				});
				// Every time the content of the editor changes, update the value of the hidden form field to match
				editor.getSession().on('change', function(){
					var code = editor.getSession().getValue();
					$('#hidden-editor{{$comment->id}}').val(code);
				});
		
				// Set Ace editor language based on language select form element
				$('#language-select{{$comment->id}}').change(function() {
					editor.getSession().setMode("ace/mode/" + $('#language-select{{$comment->id}}').val());
				});
				
				// Hide the add code section to start
				$('.code-collapse{{$comment->id}}').hide();
				
				// Toggle add code div visibility
				$('#code-title{{$comment->id}}').click(function() {
					$('.code-collapse{{$comment->id}}').toggle();
					editor.resize();
				});

				// Set up select2 menu
				$(document).ready(function() { 
					$(".select2-container{{$comment->id}}").select2();
				});
			});
		</script>
	@endif

	<p><a href="{{URL::to('profile', $comment->user_id)}}">{{{ $comment->user->first }}} {{{ $comment->user->last }}}</a>, {{{ $comment->created_at->diffForHumans() }}}</p>

	@if(Auth::user()->id == $comment->user_id)
		<button type="submit" class="btn btn-primary btn-sm" style="float:left;" id="edit{{$comment->id}}">
				<span class="glyphicon glyphicon-pencil"></span> Edit Comment
		</button>

		<div style="float:left; width:25%">
			{{ Form::open(array('url' => 'saveeditcomment', 'method'=>'post')) }}
			{{ Form::hidden('id', $comment->id) }}
			{{ Form::hidden('toSave'.$comment->id) }}
			{{ Form::hidden('toSaveCode'.$comment->id) }}
			{{ Form::hidden('toSaveNewCode'.$comment->id) }}
			{{ Form::hidden('toSaveLanguage'.$comment->id) }}
			<button type="submit" id="save{{$comment->id}}" class="btn btn-primary" style="float:left;">
					<span class="glyphicon glyphicon-floppy-saved"></span> Save
			</button>
			{{ Form::close() }}

			<button type="submit" id="cancel{{$comment->id}}" class="btn btn-warning" style="margin-left:90px;margin-top:-56px;">
					<span class="glyphicon glyphicon-floppy-remove"></span> Cancel
			</button>
		</div>

		@if(Auth::user()->admin == '0')
			<div style="float:right; width:25%">
				{{ Form::open(array('url' => 'deleteusercomment', 'method'=>'post')) }}
				{{ Form::hidden('id', $comment->id) }}
				<button type="submit" class="btn btn-danger btn-sm" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
						<span class="glyphicon glyphicon-trash"></span> Delete Comment
				</button>
				{{ Form::close() }}
			</div>
		@endif
	@endif
	
	@if(Auth::user()->admin == '1')
		{{ Form::open(array('url' => 'deletecomment', 'method'=>'post')) }}
		{{ Form::hidden('id', $comment->id) }}
		@if(Auth::user()->id == $comment->user_id)
			<button type="submit" class="btn btn-danger btn-sm" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
		@else
			<button type="submit" class="btn btn-danger btn-sm" style="float:right;margin-top:-32px;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
		@endif		
					<span class="glyphicon glyphicon-trash"></span> Delete Comment
			</button>
		{{ Form::close() }}
	@endif
	<br>
	
</div>