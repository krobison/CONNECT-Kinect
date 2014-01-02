{{ HTML::script('assets/js/ace/ace.js') }}
<script>
    @include('javascript.comment')
</script>


<div class="well">
	<div style="float:left; padding-right: 10px">
		{{HTML::image($comment->user->getProfilePictureURL(), '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle'))}}
	</div>
	
	<div>
		<p id="paragraph{{$comment->id}}">{{{ $comment->content }}}</p>
	</div>

	{{Form::open()}}
	{{ Form::hidden('revertCode'.$comment->id, $comment->code) }}
	{{Form::close()}}

	@if (!empty($comment->code))
		<div>
			Language: {{ $comment->language }}
			<div id="editor{{$comment->id}}">
			</div>
		<script>
			// Setting up the ace text editor language
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
		</script>
		</div>
	@else
		<div id="code-panel{{$comment->id}}" class="panel panel-default" style="background-color:transparent; border-style:none;">
			<div id="code-title" class="panel-body active">
				<a id="addCode{{$comment->id}}">Add code<a>
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor" type="hidden" name="code{{$comment->id}}">
			</div>

			<div id="editor" class="code-collapse"> &#10 Select your language below. &#10 Then add your code here! &#10</div>
				
			<div class="panel-footer code-collapse">
				Language: 
				<select id="language-select" class="select2-container" name="language{{$comment->id}}">
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
	@endif

	<p><a href="{{URL::to('profile', $comment->user_id)}}">{{{ $comment->user->first }}} {{{ $comment->user->last }}}</a>, {{{ $comment->created_at->diffForHumans() }}}</p>

	@if(Auth::user()->id == $comment->user_id)
		<button type="submit" class="btn btn-primary" style="float:left;" id="edit{{$comment->id}}">
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

			<button type="submit" id="cancel{{$comment->id}}" class="btn btn-warning" style="float:right;">
					<span class="glyphicon glyphicon-floppy-remove"></span> Cancel
			</button>
		</div>

		<div style="float:right; width:25%">
			{{ Form::open(array('url' => 'deleteusercomment', 'method'=>'post')) }}
			{{ Form::hidden('id', $comment->id) }}
			<button type="submit" class="btn btn-danger" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
					<span class="glyphicon glyphicon-trash"></span> Delete Comment
			</button>
			{{ Form::close() }}
		</div>
	@endif
	
	@if(Auth::user()->admin == '1')
		{{ Form::open(array('url' => 'deletecomment', 'method'=>'post')) }}
		{{ Form::hidden('id', $comment->id) }}
		<button type="submit" class="btn btn-danger" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span> Delete Comment
		</button>
		{{ Form::close() }}
	@endif
	<br>
	
</div>