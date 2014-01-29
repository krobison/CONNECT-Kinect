@if($url == 'createprojectpost')

	<style type="text/css" media="screen">
		#code-title:hover
		{ 
			background-color:white;
		}
	</style>

	<div id="new-post-body" class="panel-body">
	
		<p>
			Provide a link to your project (web site, github, public dropbox, etc...), upload a zip file of your project, or both! Also, please include a screenshot and a description of your project as well. <b> Once a post has been submitted, it will be evaluated and approved by a Connect administrator then posted on the CS Projects page. </b><br><br> Note: the screenshot and zip file must both be less than 2Mb.
		</p>

		{{ Form::open(array('url' => $url, 'method' => 'POST','files' => true)) }}

		<div class="form-group">
			<b> Upload a .zip of your project. </b>
			{{Form::file('file', array('id' => 'zip'))}}
		</div>
		<div class="form-group">
			<b> Post a link to your project. </b>
			<br>
			{{Form::url('link', null,array('placeholder' => 'http://exampleurl', 'id' => 'link' ))}}
		</div>
		<div class="form-group">
			<b> Post a screenshot of your project. </b> <span class="requiredtext"> *Required</span>
			{{Form::file('screenshot', array('id' => 'screenshot'))}}
		</div>

		<div class="form-group">
			{{ Form::textarea('content', null, array('id' => 'content-form',
													 'class' => 'form-control',
													 'placeholder' => 'Write post content here',
													 'rows' => '5')) }}
		</div>
		
		<hr>
		
		<div class="panel-tagDatater">
			<input type='hidden' style="width:100%;" id="tag-select" class="five-margin select2-container" name="hashtags[]"> </input>
			<br>
			<input type='hidden' disabled style="width:100%;" title="click a tag to add it" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
			<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		</div>

		<hr>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('id' => 'submit-button','class' => 'btn btn-lg btn-primary btn-block'))}}	
			</div>
			<div class ="col-md-8" id="javascript_errors" style="float:right, margin:5px">
			
			</div>
		</div>
		{{ Form::close() }}
	</div> 

@elseif($url == 'createhelprequestpost')

	<style type="text/css" media="screen">
		#code-title:hover
		{ 
			background-color:white;
		}
	</style>

	<div id="new-post-body" class="panel-body">
		{{ Form::open(array('url' => $url, 'method' => 'POST')) }}
		
		{{--
		<div class="form-group">
			<b> How would you like to recieve help? </b> <br>
			<i> Not Working </i> <br>
			<label class="checkbox-inline">
			{{ Form::checkbox('help_type[]', '1', array('checked' => 'true')) }}
				In the comments
			</label>
			<label class="checkbox-inline">
			{{ Form::checkbox('help_type[]', '2') }}
				In person
			</label>
		</div>
		--}}
				
		<div class="form-group">
			<b> How would you like to be displayed? </b> <br>
			<label class="radio-inline">
			{{ Form::radio('anonymous', '0', array('checked' => 'true')) }}
				Post as {{{ Auth::user()->first }}} {{{ Auth::user()->last }}}
			</label>
			<label class="radio-inline">
			{{ Form::radio('anonymous', '1') }} 
				Post Anonymously
			</label>
		</div>
		<p>
			What are you trying to do? <br>
			What does your environment look like? <br>
			Is this a compiler or run-time error? <br>
			If run-time, what conditions generate the error? <br>
			Please provide code if possible/applicable. <br>
		</p>
		
		<div class="form-group">
			{{ Form::textarea('content', null, array('id' => 'content-form',
													 'class' => 'form-control',
													 'placeholder' => 'Write post content here',
													 'rows' => '5')) }}
		</div>
		
		<div id="code-panel" class="panel panel-default" style="float:left; width:100%; text-align:center; background-color:#f4f4f4; margin-bottom:15px">
			<div id="code-title" class="panel-body active" style="padding:0px">
				<a>Add code</a>
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor" type="hidden" name="code">
			</div>

			<div id="editor" class="code-collapse" style="z-index:0; text-align:left"> &#10 &#10 &#10 &#10 </div>
				
			<div class="panel-footer code-collapse">
				Language (for syntax highlighting purposes): 
				<select id="language-select" class="select2-container" name="language" style="width:200px">
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
		
		<div class="panel-tagDatater">
			<input type='hidden' style="width:100%;" id="tag-select" class="five-margin select2-container" name="hashtags[]"> </input>
			<br>
			<input type='hidden' disabled style="width:100%;" title="Click a tag to add it" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
			<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		</div>

		
		<hr>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
			</div>
		</div>
		{{ Form::close() }}
	</div> 

@elseif($url == 'createhelpofferpost')

	<div id="new-post-body" class="panel-body">
		{{ Form::open(array('url' => $url, 'method' => 'POST')) }}
										
		<div class="form-group">
			{{ Form::textarea('content', null, array('id' => 'content-form-offer',
													 'class' => 'form-control',
													 'placeholder' => 'What do you want to help other people with? When are you available?',
													 'rows' => '5')) }}
		</div>
		
		{{--
		<div class="form-group">
			{{ Form::textarea('availability', null, array('class' => 'form-control',
													 'placeholder' => 'When are you available to help?',
													 'rows' => '5')) }}
		</div>
		--}}
		
		<hr>
		
		<div class="panel-tagDatater">
			<input type='hidden' style="width:100%;" id="tag-select-offer" class="five-margin select2-container" name="hashtags[]"> </input>
			<br>
			<input type='hidden' disabled style="width:100%;" title="Click a tag to add it" id="tag-select-suggestions-offer" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
			<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		</div>

		<hr>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
			</div>
		</div>
		{{ Form::close() }}
	</div> 

@elseif($url == 'creategeneralpost')

	<style type="text/css" media="screen">
		#code-title:hover
		{ 
			background-color:white;
		}
	</style>

	<div id="new-post-body" class="panel-body">
		{{ Form::open(array('url' => $url, 'method' => 'POST')) }}
		
		<div class="form-group">
			{{ Form::textarea('content', null, array('id' => 'content-form',
													 'class' => 'form-control',
													 'placeholder' => 'Write post content here',
													 'rows' => '5')) }}
		</div>

		<div id="code-panel" class="panel panel-default" style="float:left; width:100%; text-align:center; background-color:#f4f4f4; margin-bottom:15px">
			<div id="code-title" class="panel-body active" style="padding:0px">
				<a>Add code</a>
			</div>
			
			<div id="hidden-editor_div">
				<input id="hidden-editor" type="hidden" name="code">
			</div>

			<div id="editor" class="code-collapse" style="z-index:0; text-align:left"> &#10 &#10 &#10 &#10 </div>
				
			<div class="panel-footer code-collapse">
				Language (for syntax highlighting purposes): 
				<select id="language-select" class="select2-container" name="language" style="width:200px">
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
		
		<hr>
		
		<div class="panel-tagDatater">
			<input type='hidden' style="width:100%;" id="tag-select" class="five-margin select2-container" name="hashtags[]"> </input>
			<br>
			<input type='hidden' disabled style="width:100%;" title="Click a tag to add it" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
			<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		</div>

		<hr style="padding:7px">
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
			</div>
		</div>
		{{ Form::close() }}
	</div> 
@elseif($url == 'createcsquestionpost')

	<style type="text/css" media="screen">
		#code-title:hover
		{ 
			background-color:orange;
		}
	</style>

	<div id="new-post-body" class="panel-body">
		{{ Form::open(array('url' => $url, 'method' => 'POST')) }}
		
		<div class="form-group">
			{{ Form::textarea('content', null, array('id' => 'content-form',
													 'class' => 'form-control',
													 'placeholder' => 'Write post content here',
													 'rows' => '5')) }}
		</div>
		
		<hr>
		
		<div class="panel-tagDatater">
			<input type='hidden' style="width:100%;" id="tag-select" class="five-margin select2-container" name="hashtags[]"> </input>
			<br>
			<input type='hidden' disabled style="width:100%;" title="Click a tag to add it" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
			<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		</div>

		<hr>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
			</div>
		</div>
		{{ Form::close() }}
	</div> 
@else 
	<p> Unknown Post Type </p>
@endif


<!-- Loading all scripts at the end for performance -->
@if($url != 'createhelpofferpost')
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('assets/js/ace/ace.js') }}
{{ HTML::script('assets/js/select2.js') }}
<script>

	/*
	 * Code for Ace code editor
	 */
	 
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
	
	// Start with the 'add code' box hidden
	$('.code-collapse').hide();
	
	// Button for showing code
	$('#code-title').click(function() {
		$('.code-collapse').toggle(200);
		editor.resize();
	});

</script>

<script>
	
	var inputTagData = [
			@foreach(Hashtag::orderBy('name', 'ASC')->get() as $tag)
				{id: {{{$tag->id}}}, text: '{{{ $tag->name }}}'},
			@endforeach
			];
			
	// Get hashtag data from db
	var tagData = {
	@foreach(Hashtag::all() as $tag)
		{{{$tag->id}}} : "{{{$tag->name}}}",
	@endforeach
	}
	
	// Function to get tag id by tag name
	var returnbyValue = function(input, v) {
		for (var prop in input) {
			if (input[prop].text === v) {
				return input[prop].id;
			}
		}
		return null;
	}
	
	$(document).ready(function() { 
		// Set up select2 menus for tagging
		$("#tag-select").select2({
			createSearchChoice:function(term, data) { 
				if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {
					if(term.length > 2 && term.length < 32) {
						return {id:term.replace(/,/g,' '), text:term.replace(/,/g,' ') + " - (This will create a new tag)"};
					}
				}
			},
			multiple: true,
			placeholder: "Please select some tags for this post",
			data: inputTagData
		});
		$("#tag-select-suggestions").select2({
			multiple: true,
			placeholder: "Type some text in the post content and suggested tags will appear here",
			data: inputTagData
		});
		$("#tag-select-suggestions").change( function() {
			$('#s2id_tag-select-suggestions').unbind().click(function (event) {
				var new_selections = new Array();;
				// Collect all the things that were originally in the list
				existingData = $('#s2id_tag-select').select2("data");
				for (var selection in existingData) {
					new_selections.push({id: existingData[selection].id, text: existingData[selection].text});
				}
				
				// Collect the new tag
				var content = $(event.target ).closest(".select2-search-choice").text().trim();
				if (content !== "") {
					new_selections.push({id: returnbyValue(inputTagData, content), text: content});
				}
				
				// Add the newly selected tags to the view
				$('#s2id_tag-select').select2("data", new_selections);
			});
		});
	});
		
	/*
	 * Code for post suggestions functionality
	 */
	 
	// Populate tagData array
	
	for(var id in tagData) {
		{{-- Convert CamelCase to spaces --}}
		var myStr = tagData[id];
		myStr = myStr.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
		
		{{-- Convert hyphens and underscores to spaces --}}
		myStr = myStr.replace(/-|_/g, ' ').toLowerCase();
		
		{{-- Convert number letter junctions to spaces --}}
		myStr = myStr.replace(/([^0-9])([0-9])/g, '$1 $2').toLowerCase();
		
		{{-- Now split the string in to an array (split on whitespace) --}}
		var splitResult = myStr.split(/[ ,]+/);
		tagData[id] = splitResult;
	}
	
	// Check for new suggested tags every time content field changes
	$('#content-form').keyup(function() {
		delay(function(){
			var newSelectTwoValues = new Array;
			for(var id in tagData) {
				var toSearch = tagData[id];
				for(var word in toSearch) {
					if(toSearch[word].length > 3) {
						{{-- For security purposes, escape tag text regexp characters. --}}
						var patt = new RegExp(escapeRegExp(toSearch[word]),'i');
						if(patt.test($("#content-form").val())) {
							newSelectTwoValues.push(id);
							break;
						}
					}
				}
			}
			$("#tag-select-suggestions").select2('val',newSelectTwoValues);
			$("#tag-select-suggestions").change();
		}, 500 );
	});
	
	// This is a delay function used to require a pause in typing before executing a function with keyup()
	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	  };
	})();
	
	// Helper function to escape regex
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	// Helper function for finding the union of two arrays
	function union_arrays (x, y) {
		var obj = {};
		for (var i = x.length-1; i >= 0; -- i)
			obj[x[i]] = x[i];
		for (var i = y.length-1; i >= 0; -- i)
			obj[y[i]] = y[i];
		var res = []
		for (var k in obj) {
			if (obj.hasOwnProperty(k))  // <-- optional
			res.push(obj[k]);
		}
		return res;
	}

</script>
@else
<script>

	// Get hashtag data from db
	var tagData = {
	@foreach(Hashtag::all() as $tag)
		{{{$tag->id}}} : "{{{$tag->name}}}",
	@endforeach
	}
	
	// The reason for this script duplication is because there are two create post elements in the help center, requiring different jquery selectors
	$(document).ready(function() { 
		// Set up select2 menus for tagging
		$("#tag-select-offer").select2({
			createSearchChoice:function(term, data) { 
				if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {
					if(term.length > 2 && term.length < 32) {
						return {id:term.replace(/,/g,' '), text:term.replace(/,/g,' ') + " - (This will create a new tag)"};
					}
				}
			},
			multiple: true,
			placeholder: "Please select some tags for this post",
			data: inputTagData
		});
		$("#tag-select-suggestions-offer").select2({
			multiple: true,
			placeholder: "Type some text in the post content and suggested tags will appear here",
			data: inputTagData
		});
		$("#tag-select-suggestions-offer").change( function() {
			$('#s2id_tag-select-suggestions-offer').unbind().click(function (event) {
				var new_selections = new Array();;
				// Collect all the things that were originally in the list
				existingData = $('#s2id_tag-select-offer').select2("data");
				for (var selection in existingData) {
					new_selections.push({id: existingData[selection].id, text: existingData[selection].text});
				}
				
				// Collect the new tag
				var content = $(event.target).closest(".select2-search-choice").text().trim();
				console.log($(event.target).closest(".select2-search-choice"));
				if (content !== "") {
					new_selections.push({id: returnbyValue(inputTagData, content), text: content});
				}
				
				// Add the newly selected tags to the view
				$('#s2id_tag-select-offer').select2("data", new_selections);
			});
		});
	});
		
	/*
	 * Code for post suggestions functionality
	 */
	 
	// Populate tagData array
	
	for(var id in tagData) {
		{{-- Convert CamelCase to spaces --}}
		var myStr = tagData[id];
		myStr = myStr.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
		
		{{-- Convert hyphens and underscores to spaces --}}
		myStr = myStr.replace(/-|_/g, ' ').toLowerCase();
		
		{{-- Convert number letter junctions to spaces --}}
		myStr = myStr.replace(/([^0-9])([0-9])/g, '$1 $2').toLowerCase();
		
		{{-- Now split the string in to an array (split on whitespace) --}}
		var splitResult = myStr.split(/[ ,]+/);
		tagData[id] = splitResult;
	}
	
	// Check for new suggested tags every time content field changes
	$('#content-form-offer').keyup(function() {
		delay(function(){
			var newSelectTwoValues = new Array;
			for(var id in tagData) {
				var toSearch = tagData[id];
				for(var word in toSearch) {
					if(toSearch[word].length > 3) {
						{{-- For security purposes, escape tag text regexp characters. --}}
						var patt = new RegExp(escapeRegExp(toSearch[word]),'i');
						if(patt.test($("#content-form-offer").val())) {
							newSelectTwoValues.push(id);
							break;
						}
					}
				}
			}
			$("#tag-select-suggestions-offer").select2('val',newSelectTwoValues);
			$("#tag-select-suggestions-offer").change();
			
		}, 500 );
	});
	
	// This is a delay function used to require a pause in typing before executing a function with keyup()
	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	  };
	})();
	
	// Helper function to escape regex
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	// Helper function for finding the union of two arrays
	function union_arrays (x, y) {
		var obj = {};
		for (var i = x.length-1; i >= 0; -- i)
			obj[x[i]] = x[i];
		for (var i = y.length-1; i >= 0; -- i)
			obj[y[i]] = y[i];
		var res = []
		for (var k in obj) {
			if (obj.hasOwnProperty(k))  // <-- optional
			res.push(obj[k]);
		}
		return res;
	}
</script>
@endif