@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/helpcenter.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style type="text/css" media="screen">
    #editor { 
		width: 100%;
		height: 100px;
    }
	#new-post-buttons {
		float: right;
	}
	.five-margin {
		margin: 5px;
	}
	</style>
@stop

@section('content')

	<!-- New post functionality -->
	<div id="new-post" class="panel panel-default">
	    <div class="panel-heading">
			<h4>
			New Post
			<div class="btn-group" id="new-post-buttons">
				<button id="hide-new-post-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
			</h4>
		</div>
	    
		<div id="new-post-body" class="panel-body">
			{{ Form::open(array('url' => 'creategeneralpost', 'method' => 'POST')) }}
			
			<div class="form-group">
				{{ Form::textarea('content', null, array('id' => 'content-form',
														 'class' => 'form-control',
														 'placeholder' => 'Write post content here',
														 'rows' => '5')) }}
			</div>
					
			<div class="panel-tagDatater code-collapse">
				<select style="width:77%;" multiple id="tag-select" class="five-margin select2-container" name="hashtags[]" placeholder="Please select some tags for your post.">
					@foreach(Hashtag::all() as $tag)
						<option value={{{ $tag->id }}}>{{{ $tag->name }}}</option>
					@endforeach
				</select>
				<br>
				<select disabled style="width:77%;" multiple id="tag-select-suggestions" class="five-margin select2-container" name="hashtag_suggestions[]" placeholder="Type some content, some suggested tags will appear here.">
					@foreach(Hashtag::all() as $tag)
						<option value={{{ $tag->id }}}>{{{ $tag->name }}}</option>
					@endforeach
				</select>
				<button type="button" style="width:20%" id="add-these-tags" class="btn btn-primary"> <small>Add These Tags</small> </button>
			</div>

			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
					{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
				</div>
			</div>
			{{ Form::close() }}
		</div> 
	</div>
	
	<!-- Generate all recent user posts -->
	@foreach ($posts as $post)
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
	@endforeach
	
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
			$(".select2-container").select2();
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
			alert("I don't work yet");
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

	</script>
@stop