/*
 * Code for post suggestions functionality
 */
 
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('assets/js/select2.js') }}
 
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
	union_arrays
	$("#tag-select").select2('val',union_arrays($("#tag-select-suggestions").val(),$("#tag-select").val()));
	//alert("I don't work yet");
});

// Check for new suggested tags every time content field changes
$('#content-form').keyup(function() {
	var newSelectTwoValues = new Array;
	@foreach(Hashtag::all() as $tag)
		// Check the content area for each piece of the new array
		var toSearch = tagData['{{{$tag->id}}}'];
		for(i = 0; i < toSearch.length; i++) {
			var patt = new RegExp(toSearch[i],'i'); // Minor security concerns about a possible user supplied regex
			if(patt.test($("#content-form").val())) {
				newSelectTwoValues.push({{{$tag->id}}});
				break;
			}
		}
	@endforeach
	$("#tag-select-suggestions").select2('val',newSelectTwoValues);
});

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
		