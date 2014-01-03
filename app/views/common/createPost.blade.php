<style type="text/css" media="screen">
	#code-title:hover
	{ 
		background-color:orange;
	}
</style>

<div id="new-post-body" class="panel-body">
	@if($url == 'createprojectpost')
		{{ Form::open(array('url' => $url, 'method' => 'POST','files' => true)) }}
	@else 
		{{ Form::open(array('url' => $url, 'method' => 'POST')) }}
	@endif
	THIS IS A {{ $url }} POST <br>
	
	@if($url == 'createhelprequestpost') 
	
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
			
	@endif

	@if($url == 'createprojectpost')
		<div class="form-group">
			<b> Upload a .zip of your project. </b>
			{{Form::file('file', array())}}
		</div>
		<div class="form-group">
			<b> Post a link to your project. </b>
			<br>
			{{Form::url('link', null,array('placeholder' => 'http://exampleurl' ))}}
		</div>
		<div class="form-group">
			<b> Post a screenshot of your project. </b>
			{{Form::file('screenshot', array())}}
		</div>
	@endif
	
	<div class="form-group">
		{{ Form::textarea('content', null, array('id' => 'content-form',
												 'class' => 'form-control',
												 'placeholder' => 'Write post content here',
												 'rows' => '5')) }}
	</div>
	
	@if($url != 'createprojectpost')
	<div id="code-panel" class="panel panel-default">
		<div id="code-title" class="panel-body active">
			Add code
		</div>
		
		<div id="hidden-editor_div">
			<input id="hidden-editor" type="hidden" name="code">
		</div>

		<div id="editor" class="code-collapse">
		
		Select your language below
		Then add your code here!
		
		</div>
			
		<div class="panel-footer code-collapse">
			Language: 
			<select id="language-select" class="select2-container" name="language" style="width:25%">
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
	<hr>
	
	<div class="panel-tagDatater">
		<input type='hidden' style="width:77%;" id="tag-select" class="five-margin select2-container" name="hashtags[]"> </input>
		<br>
		<input type='hidden' disabled style="width:77%;" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]"> </input>
		<noscript> This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled. </noscript>
		<button type="button" style="width:20%" id="add-these-tags" class="btn btn-default"> <small>Add These Tags</small> </button>
	</div>

	<hr>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
		</div>
	</div>
	{{ Form::close() }}
</div> 

<!-- Loading all scripts at the end for performance -->

{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('assets/js/ace/ace.js') }}
{{ HTML::script('assets/js/select2.js') }}
@if($url != 'createcsquestionpost')
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
@endif

<script>
	
	$(document).ready(function() { 
		// Set up select2 menus for tagging
		$("#tag-select").select2({
			createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term.replace(/,/g,' '), text:term.replace(/,/g,' ') + " - (This will create a new tag)"};} },
			multiple: true,
			placeholder: "Please select some tags for this post",
			data:
			[
			@foreach(Hashtag::orderBy('name', 'ASC')->get() as $tag)
				{id: {{{$tag->id}}}, text: '{{{ $tag->name }}}'},
			@endforeach
			]
		});
		$("#tag-select-suggestions").select2({
			createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term.replace(/,/g,' '), text:term.replace(/,/g,' ') + " - (This will create a new tag)"};} },
			multiple: true,
			placeholder: "Type some text in the post content and suggested tags will appear here",
			data:
			[
			@foreach(Hashtag::orderBy('name', 'ASC')->get() as $tag)
				{id: {{{$tag->id}}}, text: '{{{ $tag->name }}}'},
			@endforeach
			]
		});
	});
	
		
	/*
	 * Code for post suggestions functionality
	 */
	 
	// Populate tagData array
	
	// Get hashtag data from db
	var tagData = {
	@foreach(Hashtag::all() as $tag)
		{{{$tag->id}}} : "{{{$tag->name}}}",
	@endforeach
	40:"llamasAre233soCool23"}
	
	for(var id in tagData) {
		{{-- Convert CamelCase to spaces --}}
		var myStr = tagData[id];
		myStr = myStr.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
		
		{{-- Convert hyphens and underscores to spaces --}}
		myStr = myStr.replace(/-|_/g, ' ').toLowerCase();
		
		{{-- Convert number letter junctions to spaces --}}
		myStr = myStr.replace(/([^0-9])([0-9])/g, '$1 $2').toLowerCase();
		
		{{-- Now split the string in to an array (split on every space) --}}
		var splitResult = myStr.split(" ");
		tagData[id] = splitResult;
	}

	// Add suggested tags to actual tags on button press
	$('#add-these-tags').click(function() {
		var unionOfSelectMenues = union_arrays($("#tag-select-suggestions").val().split(","),$("#tag-select").val().split(","));
		$("#tag-select").select2('val',unionOfSelectMenues);
	});
	
	// Check for new suggested tags every time content field changes
	$('#content-form').keyup(function() {
		var newSelectTwoValues = new Array;
		for(var id in tagData) {
			var toSearch = tagData[id];
			for(i = 0; i < toSearch.length; i++) {
				{{-- For security purposes, escape tag text to regexp characters. --}}
				var patt = new RegExp(escapeRegExp(toSearch[i]),'i');
				if(patt.test($("#content-form").val())) {
					newSelectTwoValues.push(id);
					break;
				}
			}
		}
		$("#tag-select-suggestions").select2('val',newSelectTwoValues);
	});
	
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