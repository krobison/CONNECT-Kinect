<div class="ajax-container" title="Click to see more" style="margin-bottom:16px;padding:5px;border:1px #CCCCCC solid;border-radius:4px; float:left;width:100%">    
    
	{{-- Display the profile picture (if it exists) and user is not anonmyous--}}
	
		<div style="float:left; padding-right: 10px; padding-bottom: 5px">
			@if (isset($detail) && $detail == "true")
				@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
					{{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '76', 'height' => '76', 'class' => 'img-circle')) }}
				@else
					<a href="{{URL::to('profile', $post->user->id)}}">
						{{HTML::image($post->user->getProfilePictureURL(), '$post->user->id', array('width' => '76', 'height' => '76', 'class' => 'img-circle'))}}
					</a>
				@endif
			@else
				@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
					{{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '46', 'height' => '46', 'class' => 'img-circle')) }}
				@else
					<a href="{{URL::to('profile', $post->user->id)}}">
						{{HTML::image($post->user->getProfilePictureURL(), '$post->user->id', array('width' => '46', 'height' => '46', 'class' => 'img-circle'))}}
					</a>
				@endif
			@endif
		</div>
		
	<div id="post-options-panel" style="float:right; width:150px">
	{{-- Display hidden save and edit post buttons --}}
		
		@if(Auth::user()->id == $post->user_id && isset($detail) && $detail == "true")
			
			<div style="float:left">
				{{ Form::open(array('url' => 'saveeditpost', 'method'=>'post')) }}
				{{ Form::hidden('id', $post->id) }}
				{{ Form::hidden('toSave') }}
				{{ Form::hidden('toSaveCode') }}
				{{ Form::hidden('toSaveNewCode') }}
				{{ Form::hidden('toSaveLanguage') }}
				{{ Form::hidden('toSaveTags') }}
				<button type="submit" id="saveEditedPost" class="btn btn-success two-marg" style="float:left;">
						<span class="glyphicon glyphicon-floppy-saved"></span> Save
				</button>
				{{ Form::close() }}

				<button type="submit" id="cancelEditingPost" class="btn btn-warning two-marg" style="margin-right:100px; margin-left:90px;margin-top:-56px;">
						<span class="glyphicon glyphicon-floppy-remove"></span> Cancel
				</button>
				<br>
			</div>
			
		@endif
	
	{{-- Display the upvote button --}}
	
		<div style="padding-left:15px">
				{{ Form::hidden('user_id', Auth::user()->id)}}
				{{ Form::hidden('post_id', $post->id, array('id' => 'post-id')) }}
						<?php
								$result = DB::table('upvotes')->where('user_id','=',Auth::User()->id)->where('post_id','=',$post->id)->get();
						?>
						@if (sizeof($result) == 0)
								<button title="Upvote this post" type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-default btn-sm upvote-ajax" style="float:right; margin: 2px">
									<i class="image glyphicon glyphicon-hand-up"></i> {{ $post->postupvotes->count() }}</button>
						@else
								<button title="Undo your upvote of this post" type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-success btn-sm upvote-ajax" style="float:right; margin: 2px">
									<i class="image glyphicon glyphicon-hand-down"></i> {{$post->postupvotes->count()}}</button>
						@endif
		</div>
		
	{{-- Display the edit post button if post belongs to the user and the details are enabled --}}
		@if(Auth::user()->id == $post->user_id && isset($detail) && $detail == "true")
			<button type="editPost" class="btn btn-primary btn-sm two-marg" title="Edit this post" style="float:right; margin:2px" id="editPost">
					<span class="glyphicon glyphicon-pencil"></span>
			</button>
		@endif
		
	{{-- Display the Delete Post button if user is an admin or the post belongs to the user--}}
	
		@if ((Auth::user()->admin == '1')||($post->user_id == Auth::user()->id))
			{{ Form::open(array('url' => 'deletepost', 'method'=>'post')) }}
			{{ Form::hidden('id', $post->id) }}
			<button type="submit" class="btn btn-danger btn-sm" style="float:right; margin: 2px; margin-left: 4px" title="Delete this post" onclick="return confirm('Are you sure you would like to delete this post FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			{{ Form::close() }}
		@endif
		
	</div>
		
		
	{{-- Display the post content --}}
	
        @if (isset($detail) && $detail == "true")
            <div id="paragraph" style="white-space:pre-wrap">{{$post->getPurifiedContent()}}</div>
        @else
            <div class="list-group" style="margin-left:60px;margin-right:56px;margin-bottom:0px">
                    <h4 style="margin-bottom:5px"><a href="{{URL::to('singlepost', $post->id)}}" class="list-group-item" style="padding-bottom:4px; padding-top:4px; padding-left:7px;max-height:72px;overflow:hidden;font-size:11pt; white-space: pre-wrap; line-height:110%">{{{ strip_tags($post->content) }}}</a></h4>
            </div>
        @endif
	
	{{-- Edit Post functionality --}}
	
		@if(Auth::user()->id == $post->user_id && isset($detail) && $detail == "true")
			
			{{-- Code Editor --}}
			<br>
			{{Form::open()}}
			{{ Form::hidden('revertCode', $post->code) }}
			{{ Form::hidden('revertContent', $post->content) }}
			{{Form::close()}}

			@if (!empty($post->code))
				<div>
					<div id="disp-lang">Language: {{{$post->language}}} </div>
					<div id="editor" class="post-code-collapse" style="width:100%; height:100px; text-align:left"> &#10 &#10 &#10 &#10 </div>
					
					<div id="langSelect" class="panel-footer post-code-collapse">
						Language (for syntax highlighting purposes): 
						<select id="language-select" class="select2-container" name="language">
							@foreach(Post::getSupportedLanguages() as $language)
								@if ($language === $post->language)
									<option selected value={{{ $language }}}>{{{ ucfirst($language) }}}</option>
								@else
									<option value={{ $language }}>{{{ ucfirst($language) }}}</option>
								@endif
							@endforeach
						</select>
					</div>
				<script>
					// Setting up the ace text editor language
					$( document ).ready(function() {
						var editor = ace.edit("editor");
						editor.setValue($('[name="revertCode"]').val().trim());
						editor.getSession().setUseWorker(false);
						editor.setTheme("ace/theme/eclipse");
						var language = "{{$post->language}}";
						editor.getSession().setMode("ace/mode/" + language);
						editor.setReadOnly(true);
						editor.setOptions({
							maxLines: 50
						});
					});
				</script>
				</div>
				<br>
			@else
				@if($post->postable_type != 'PostHelpOffer' && $post->postable_type != 'PostProject')
					<div id="code-panel" class="panel panel-default" style="float:left; width:100%; border-style:none; text-align:center">
						<div id="code-title" class="panel-body active" style="padding:0px">
							<a id="addCode">Add code</a>
						</div>
						
						<div id="hidden-editor_div">
							<input id="hidden-editor" type="hidden" name="code">
						</div>

						<div id="editor" class="post-code-collapse" style="width:100%; height:100px; text-align:left"> &#10 &#10 &#10 &#10 </div>
							
						<div class="panel-footer post-code-collapse">
							Language (for syntax highlighting purposes): 
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
					
					<script>
						$( document ).ready(function() {
							// Setting up the ace text editor language
							var editor = ace.edit("editor");
							editor.getSession().setUseWorker(false);
							editor.setTheme("ace/theme/eclipse");
							editor.getSession().setMode("ace/mode/plain_text");
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
							
							// Hide the add code section on start
							$('.post-code-collapse').hide();
							
							// Toggle add code div visibility
							$('#code-title').click(function() {
								$('.post-code-collapse').toggle();
								editor.resize();
							});
							
							// Set up select2 menu
							$(document).ready(function() { 
								$(".select2-container").select2();
							});
						});
					</script>
				@endif
			@endif
			<script>
			
			$(window).load(function() {
					$("#saveEditedPost").hide();
					$("#cancelEditingPost").hide();
					$("#code-panel").hide();
					$("#langSelect").hide();
					$("#old-tags").show();
					$("#name-time").show();
					$("#new-tags").hide();
					@if(Auth::user()->id == $post->user_id)
						$("#editPost").click(function() { /* assign anonymous function to click event */
							// Fix some styling
							$("#post-options-panel").width(400);
							$("#disp-lang").hide();
							$("#langSelect").show();
							$("#old-tags").hide();
							$("#new-tags").show();
							$("#name-time").hide();
							
							var p = $("#paragraph"); /* store reference to <div> element */

							 /* get p.text() without the formatting */
							 //var t = p.text().replace("\n", "").replace(/\s{2,}/g, " ").trim();
							 
							 // Actually, I'd rather keep the formatting, thank you very much! (also html not text cuz we want tags)
							 var t = p.html()

							/* create new textarea element with additional attributes */
							var ta = $("<textarea/>", {
								"class": "edit form-control",
								"id": "editbox",
								"text": t,
								"css": {
									"width": p.css('width'),
									"height": "300px"
								}
							});

							$("#saveEditedPost").show();
							$("#saveEditedPost").attr("disabled", true);
							ta.keyup(function() {
								$('[name="toSave"]').attr('value', $(this).val());
								updateHiddenFields();
							});
							
							$('#tagSelect').on("change", function() {
								updateHiddenFields();
							});

							p.replaceWith(ta); /* replace p with ta */
							$("#cancelEditingPost").show();
							$("#editPost").hide();
							@if (!empty($post->code))
								ace.edit("editor").setReadOnly(false);
								ace.edit("editor").on("change", function() {
									updateHiddenFields();
									if ($('[name="toSaveCode"]').val() == "") {
										$('[name="toSaveCode"]').attr('value', "hideCode");	
									}
								});
								$('#language-select').on("change", function() {
									updateHiddenFields();
								});
							@else
								$("#code-panel").show();
								ace.edit("editor").on("change", function() {
									$("#saveEditedPost").attr("disabled", false);
									$('[name="toSaveNewCode"]').attr('value', ace.edit("editor").getValue().trim());
								});
								$('#language-select').on("change", function() {
									updateHiddenFields();
								});
							@endif
						});
					@endif

					$("#cancelEditingPost").click(function() {
						$("#post-options-panel").width(150);
						$("#langSelect").hide();
						$("#saveEditedPost").hide();
						$("#cancelEditingPost").hide();
						$("#code-panel").hide();
						$("#disp-lang").show();
						$("#old-tags").show();
						$("#new-tags").hide();
						$("#name-time").show();
						var p = $("#editbox"); /* store reference to <p> element */

						/* create new textarea element with additional attributes */
						var ta = $("<div/>", {
							"id": "paragraph",
							"html": $('[name="revertContent"]').val(),
							"css": {
								"width": p.css('width'),
								"white-space": p.css('white-space')
							}
						});

						p.replaceWith(ta); /* replace p with ta */
						$('[name="toSave"]').attr('value', "");
						$("#editPost").show();
						@if (!empty($post->code))
							var editor = ace.edit("editor");
							var code = $('[name="revertCode"]').val().trim();
							editor.setReadOnly(true);
							editor.setValue(code);
							$('[name="toSaveCode"]').attr('value', "");
							$('[name="toSaveNewCode"]').attr('value', "");
							$('[name="toSaveNewLanguage"]').attr('value', "");
						@endif
					});
				});
			
			var updateHiddenFields = function() {
				// Note the content of the post is saves separately
				$('[name="toSaveTags"]').attr('value', $("#tagSelect").val());
				$('[name="toSaveLanguage"]').attr('value', $(".select2-chosen").html());
				$('[name="toSaveCode"]').attr('value', ace.edit("editor").getValue().trim());
				$("#saveEditedPost").attr("disabled", false);
			}
			
			</script>
			
		@endif

    {{-- Display the name of the user who made the post (if the user is not anonymous) --}}
		
		<div id="name-time">
        @if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
            <p style="margin-bottom:5px">Anonymous, {{ $post->created_at->diffForHumans() }}</p>
        @else
            <p style="margin-bottom:5px"><a href="{{URL::to('profile', $post->user->id)}}">{{{ $post->user->first }}} {{{ $post->user->last }}}</a>, {{ $post->created_at->diffForHumans() }} <span style="float:right; margin-right:150px"><a href="{{URL::to('singlepost', $post->id)}}">{{{$post->comments()->count()}}} Comment(s)</a> </span> </p>
        @endif
		</div>

        {{-- Display tags --}}

        <style>
            .hashtag{
                padding:4px;
                font-family:"Trebuchet MS", Helvetica, sans-serif;
                font-weight:bold;
                display:inline-block;
                margin-bottom:2px;
                background-color:rgba(0,0,0,0.15); 
                border:1px rgba(0,0,0,0.15) solid;
            }
        </style>

		<div id="old-tags">
		@foreach($post->hashtags as $tag)
			<small class="hashtag" style="color:#000000;">#{{{$tag->name}}}</small>
		@endforeach
		</div>
		
		@if(Auth::user()->id == $post->user_id && isset($detail) && $detail == "true")
		<div id="new-tags" class="form-group">
			<select multiple class="select2-container-tags classSelect" name="hashtags[]" id="tagSelect" style="width:100%">
				@foreach($tagHTML as $html)
					{{$html}}
				@endforeach
			</select>
			<script>
				$(document).ready(function() { 
					$(".select2-container-tags").select2({
						placeholder: "Add some tags"
					});
				});
			</script>
		</div>
		@endif
		

		
</div>

{{ HTML::script('assets/js/ajaxUpvote.js') }}

