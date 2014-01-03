{{ HTML::script('assets/js/ace/ace.js') }}

<div id="new-post-body" class="panel-body">
	{{ Form::open(array('url' => 'creategeneralpost', 'method' => 'POST')) }}
	
	THIS IS A {{ $url }} POST <br>
	
	<div class="form-group">
		{{ Form::textarea('content', null, array('id' => 'content-form',
												 'class' => 'form-control',
												 'placeholder' => 'Write post content here',
												 'rows' => '5')) }}
	</div>
			
	<div class="panel-tagDatater code-collapse">
		<input type='hidden' style="width:77%;" id="tag-select" class="five-margin select2-container" name="hashtags[]">
		</input>
		<br>
		<input type='hidden' disabled style="width:77%;" id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]">
		</input>
		<noscript> This browser does not support JavaScript, or JavaScript is turned off. Tagging is disabled. </noscript>
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
{{ HTML::script('assets/js/select2.js') }}
	
<script>

	// Hide and show post divs on button press
	$('#hide-new-post-button').click(function() {
		$('#new-post-body').toggle(200);
	});
	
	$(document).ready(function() { 
		// Set up select2 menu
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
	var tagData = {};
	@foreach(Hashtag::all() as $tag)
		
		// Convert CamelCase to spaces
		var myStr = '{{{ $tag->name }}}';
		myStr = myStr.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
		
		// Convert hyphens and underscores to spaces
		myStr = myStr.replace(/-|_/g, ' ').toLowerCase();
		
		// Convert number letter junctions to spaces
		myStr = myStr.replace(/([0-9])([^0-9])/g, '$1 $2').toLowerCase();
		myStr = myStr.replace(/([^0-9])([0-9])/g, '$1 $2').toLowerCase();
		
		// Now split the string in to an array (split on every space)
		var splitResult = myStr.split(" ");
		tagData['{{{$tag->id}}}'] = splitResult;
		//console.log(tagData['{{{ $tag->id }}}']);

	@endforeach

	// Add suggested tags to actual tags on button press
	$('#add-these-tags').click(function() {
		var unionOfSelectMenues = union_arrays($("#tag-select-suggestions").val().split(","),$("#tag-select").val().split(","));
		$("#tag-select").select2('val',unionOfSelectMenues);
	});
	
	// Check for new suggested tags every time content field changes
	$('#content-form').keyup(function() {
		var newSelectTwoValues = new Array;
		@foreach(Hashtag::all() as $tag)
			// Check the content area for each piece of the new array
			var toSearch = tagData['{{{$tag->id}}}'];
			for(i = 0; i < toSearch.length; i++) {
				// Escape taged text to regexp characters.
				var patt = new RegExp(escapeRegExp(toSearch[i]),'i');
				if(patt.test($("#content-form").val())) {
					newSelectTwoValues.push({{{$tag->id}}});
					break;
				}
			}
		@endforeach
		$("#tag-select-suggestions").select2('val',newSelectTwoValues);
	});
	
	// Helper function to escape regex
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	// Helper function for funding the union of two arrays
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