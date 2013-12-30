<div class="well">
	<div style="float:left; padding-right: 10px">
		{{HTML::image($comment->user->getProfilePictureURL(), '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle'))}}
	</div>
	
	<p>{{{ $comment->content }}}</p>
	<p>{{{ $comment->user->first }}} {{{ $comment->user->last }}}, {{{ $comment->created_at->diffForHumans() }}}</p>

	@if (!empty($comment->code))
		<br>
			Language: {{ $comment->language }}
			<div id="editor{{$comment->id}}">
				{{{ $comment->code }}}
			</div>
	
		{{ HTML::script('assets/js/ace/ace.js') }}
		<script>
			// Setting up the ace text editor language
			var editor = ace.edit("editor{{$comment->id}}");
			editor.getSession().setUseWorker(false);
			editor.setTheme("ace/theme/eclipse");
			var language = "{{$comment->language}}";
			editor.getSession().setMode("ace/mode/" + language);
			editor.setReadOnly(true);
			editor.setOptions({
				maxLines: 50
			});
		</script>
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