{{ HTML::script('assets/js/ace/ace.js') }}
<script>
	$(window).load(function() {
		$("#save{{$comment->id}}").hide();
		$("#cancel{{$comment->id}}").hide();
		@if(Auth::user()->id == $comment->user_id)
			$("#edit{{$comment->id}}").click(function() { /* assign anonymous function to click event */
	    		var p = $("#paragraph{{$comment->id}}"); /* store reference to <p> element */

	   			 /* get p.text() without the formatting */
	   			 var t = p.text().replace("\n", "").replace(/\s{2,}/g, " ").trim();

	    		/* create new textarea element with additional attributes */
	    		var ta = $("<textarea/>", {
	        		"class": "edit",
	        		"id": "editbox{{$comment->id}}",
	        		"text": t,
	        		"css": {
	            		"width": p.css('width')
	        		}
	    		});

	    		$("#save{{$comment->id}}").show();
	    		$("#save{{$comment->id}}").attr("disabled", true);
	    		ta.keyup(function() {
	    			$('[name="toSave{{$comment->id}}"]').attr('value', $(this).val());
	    			$("#save{{$comment->id}}").attr("disabled", false);
	    		});

	    		p.replaceWith(ta); /* replace p with ta */
	    		$("#cancel{{$comment->id}}").show();
	    		$("#edit{{$comment->id}}").hide();
	    		@if (!empty($comment->code))
	    			ace.edit("editor{{$comment->id}}").setReadOnly(false);
	    			ace.edit("editor{{$comment->id}}").on("change", function() {
	    				$("#save{{$comment->id}}").attr("disabled", false);
	    				$('[name="toSaveCode{{$comment->id}}"]').attr('value', ace.edit("editor{{$comment->id}}").getValue());
	    			});
	    		@endif
	    	});
		@endif

    	$("#cancel{{$comment->id}}").click(function() {
    		$("#save{{$comment->id}}").hide();
			$("#cancel{{$comment->id}}").hide();
			var p = $("#editbox{{$comment->id}}"); /* store reference to <p> element */

    		/* create new textarea element with additional attributes */
    		var ta = $("<p/>", {
    			"id": "paragraph{{$comment->id}}",
        		"text": "{{$comment->content}}",
        		"css": {
            		"width": p.css('width')
        		}
    		});

    		p.replaceWith(ta); /* replace p with ta */
			$('[name="toSave{{$comment->id}}"]').attr('value', "");
			$("#edit{{$comment->id}}").show();
			@if (!empty($comment->code))
				var editor = ace.edit("editor{{$comment->id}}");
				// var code = "{{--$comment->code--}}";
				editor.setReadOnly(true);
				//editor.setValue(code);
    			$('[name="toSaveCode{{$comment->id}}"]').attr('value', "");
	    	@endif
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
		<button type="submit" class="btn btn-primary" style="float:left;" id="edit{{$comment->id}}">
				<span class="glyphicon glyphicon-pencil"></span> Edit Comment
		</button>

		<div style="float:left; width:25%">
			{{ Form::open(array('url' => 'saveeditcomment', 'method'=>'post')) }}
			{{ Form::hidden('id', $comment->id) }}
			{{ Form::hidden('toSave'.$comment->id) }}
			{{ Form::hidden('toSaveCode'.$comment->id) }}
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