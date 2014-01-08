	$(window).load(function() {
		$("#save{{$comment->id}}").hide();
		$("#cancel{{$comment->id}}").hide();
		$("#code-panel{{$comment->id}}").hide();
		@if(Auth::user()->id == $comment->user_id)
			$("#edit{{$comment->id}}").click(function() { /* assign anonymous function to click event */
	    		var p = $("#paragraph{{$comment->id}}"); /* store reference to <div> element */

	   			 /* get p.text() without the formatting */
	   			 //var t = p.text().replace("\n", "").replace(/\s{2,}/g, " ").trim();
				 
				 // Actually, I'd rather keep the formatting, thank you very much!
				 var t = p.text()

	    		/* create new textarea element with additional attributes */
	    		var ta = $("<textarea/>", {
	        		"class": "edit form-control",
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
	    				$('[name="toSaveCode{{$comment->id}}"]').attr('value', ace.edit("editor{{$comment->id}}").getValue().trim());
	    				if ($('[name="toSaveCode{{$comment->id}}"]').val() == "") {
	    					$('[name="toSaveCode{{$comment->id}}"]').attr('value', "hideCode");	
	    				}
	    			});
	    		@else
	    			$("#code-panel{{$comment->id}}").show();
	    			ace.edit("editor{{$comment->id}}").on("change", function() {
						$("#save{{$comment->id}}").attr("disabled", false);
						$('[name="toSaveNewCode{{$comment->id}}"]').attr('value', ace.edit("editor{{$comment->id}}").getValue().trim());
					});
					$('#language-select{{$comment->id}}').on("change", function() {
						$('[name="toSaveLanguage{{$comment->id}}"]').attr('value', $(".select2-chosen").html());
					});
	    		@endif
	    	});
		@endif

    	$("#cancel{{$comment->id}}").click(function() {
    		$("#save{{$comment->id}}").hide();
			$("#cancel{{$comment->id}}").hide();
			$("#code-panel{{$comment->id}}").hide();
			var p = $("#editbox{{$comment->id}}"); /* store reference to <p> element */

    		/* create new textarea element with additional attributes */
    		var ta = $("<div/>", {
    			"id": "paragraph{{$comment->id}}",
        		"text": $('[name="revertContent{{$comment->id}}"]').val().trim(),
        		"css": {
            		"width": p.css('width')
        		}
    		});

    		p.replaceWith(ta); /* replace p with ta */
			$('[name="toSave{{$comment->id}}"]').attr('value', "");
			$("#edit{{$comment->id}}").show();
			@if (!empty($comment->code))
				var editor = ace.edit("editor{{$comment->id}}");
				var code = $('[name="revertCode{{$comment->id}}"]').val().trim();
				editor.setReadOnly(true);
				editor.setValue(code);
    			$('[name="toSaveCode{{$comment->id}}"]').attr('value', "");
    			$('[name="toSaveNewCode{{$comment->id}}"]').attr('value', "");
    			$('[name="toSaveNewLanguage{{$comment->id}}"]').attr('value', "");
	    	@endif
    	});
	});