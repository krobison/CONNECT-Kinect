<script>
	$(window).load(function() {
		$("#save").hide();
		$("#edit").click(function() { /* assign anonymous function to click event */
    		alert($("#paragraph{{$comment->id}}").text());
    		var p = $("#paragraph{{$comment->id}}"); /* store reference to <p> element */

   			 /* get p.text() without the formatting */
   			 var t = p.text().replace("\n", "").replace(/\s{2,}/g, " ").trim();

    		/* create new textarea element with additional attributes */
    		var ta = $("<textarea/>", {
        		"class": "edit",
        		"id": "editbox",
        		"text": t,
        		"css": {
            		"width": p.css('width')
        		}
    		});

    		$("#editbox").ready(function() {
    			$("#editbox").keyup(function() {
  					alert( "Handler for .keypress() called." );
				});
    		});

    		p.replaceWith(ta); /* replace p with ta */
    		$("#save").show();
    		$("#edit").hide();
    	});
	});
</script>

<div class="well">
	<div style="float:left; padding-right: 10px">
		{{HTML::image($comment->user->getProfilePictureURL(), '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle'))}}
	</div>
	
	<div>
		<p id="paragraph{{$comment->id}}">{{{ $comment->content }}}</p>
	</div>

	@if (!empty($comment->code))
		<div>
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
		</div>
	@endif

	<p>{{{ $comment->user->first }}} {{{ $comment->user->last }}}, {{{ $comment->created_at->diffForHumans() }}}</p>

	@if(Auth::user()->id == $comment->user_id)
		<button type="submit" class="btn btn-primary" style="float:left;" id="edit">
				<span class="glyphicon glyphicon-pencil"></span> Edit Comment
		</button>

		{{ Form::open(array('url' => 'saveeditcomment', 'method'=>'post')) }}
		{{ Form::hidden('id', $comment->id) }}
		{{ Form::hidden('toSave') }}
		<button type="submit" id="save" class="btn btn-primary" style="float:left;">
				<span class="glyphicon glyphicon-floppy-saved"></span> Save
		</button>
		{{ Form::close() }}

		{{ Form::open(array('url' => 'deleteusercomment', 'method'=>'post')) }}
		{{ Form::hidden('id', $comment->id) }}
		<button type="submit" class="btn btn-danger" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span> Delete Comment
		</button>
		{{ Form::close() }}
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