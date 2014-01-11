@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/posts.css') }}
	<style>
	.panel-heading:hover{ 
		background-color:orange;
	}
	.first-on-page{
		margin-top:5px;
	}
	hr {
		margin:0px;
		padding:0px;
	}
	h4 {
		margin:0px;
		padding:0px;
	}
	</style>
@stop

@section('title')
	NEWSFEED.
@stop

@section('content')

	<!-- New post functionality -->
	<div id="new-post" class="panel panel-default first-on-page">
	    <div>
			<div id="new-post-title" class="span6 panel-heading" title="Make a post about anything. It will appear to all CS Connect users below. Not enough guidance? Fine. Examples: Post about your favourite programming language, Open invite to dinner at your house tonight, What band did you vote to come to e-days?, SuperBowl predictions, Link to your favourite xkcd, Anything. Just make sure to tag your post.">
			<h4>
			Create New Post
			<a style="float:right" target="_blank" href="http://htmlpurifier.org/"><img src="http://htmlpurifier.org/live/art/powered.png" alt="Powered by HTML Purifier" border="0" /></a>
			</h4>
			</div>
			<hr>
			<div id="search-post-title"class="span6 panel-heading">
			<h4>
			Search Posts
			</h4>
			</div>
			<hr>
		</div>
		<div id="new-post-content" class="panel-body">
			{{ View::make('common/createPost')->with('url', 'creategeneralpost') }}
		</div>
		<div id="search-posts-content" class="panel-body">
		{{ Form::open(array('url' => 'searchposts', 'method' => 'GET')) }}
			<div class="form-group">
				<b>Upvotes</b> <br>
				<label class="checkbox-inline">
				@if(!empty($oldsort) && $oldsort[0] == '1')
				{{ Form::checkbox('sort[]', '1', 'true') }}
				@else
				{{ Form::checkbox('sort[]', '1') }}
				@endif
					Sort by number of upvotes
				</label>
				
				<br><br>
				<b>Hashtags</b> </br>
				<select multiple class="select2-container-hashtagsearch classSelect" name="hashtags[]">
					<optgroup label="Hashtags">
						@foreach(Hashtag::all() as $hashtag)
							<option value={{ $hashtag->id }}>{{ $hashtag->name }}</option>
						@endforeach
					</optgroup>
					@if (!empty($oldhashtags))
							@foreach($oldhashtags as $hashtag)
								<option selected value={{{ $hashtag->id }}}>
									{{{ $hashtag->name }}}
								</option>
							@endforeach
					@endif
				</select>
				<br><br>
				
				<b>Content</b> </br>
					<div class="form-group">
					@if(!empty($oldcontent))
					{{ Form::textarea('content', $oldcontent, array('id' => 'content-form',
							'class' => 'form-control',
							'placeholder' => 'Search for content within a post',
							'rows' => '5')) }}
					@else
					{{ Form::textarea('content', null, array('id' => 'content-form',
							'class' => 'form-control',
							'placeholder' => 'Search for content within a post',
							'rows' => '5')) }}
					@endif
					</div>
			</div>
			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
				{{Form::submit('Search', array('class' => 'btn btn-lg btn-primary btn-block'))}}	
				</div>
			</div>
			{{ Form::close() }}
		{{ Form::close() }}
		</div>
	</div>
	
	<!-- Generate all recent user posts -->
	<div id="postswrapper">
	@foreach ($posts as $postid)
		<?php 
		$post = Post::find($postid->id)
		?>
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
		<div class="postitem" id="{{$post->id}}"></div>
	@endforeach
	</div>
	<div id="loadmorebutton">
	<button type="button" class="btn btn-default">Load more...</button>
	</div>
	</br>
	
	
	<!-- Loading all scripts at the end for performance -->
	<script>

		// Hide and show post divs on button press
		$('#new-post-title').click(function() {
			$('#new-post-content').toggle(200);
			$('#search-posts-content').hide();
		});
		
		$('#search-post-title').click(function() {
			$('#search-posts-content').toggle(200);
			$('#new-post-content').hide();
		});
		
		$(document).ready(function() { 
			$(".select2-container-hashtagsearch").select2({
				placeholder: "Select Hashtags"
			});
			
			$('#new-post-content').hide();
			$('#search-posts-content').hide();
		});
		
		var ID = $(".postitem:last").attr("id");
		var content = "<?php if(!empty($oldcontent)) {echo $oldcontent;} ?>";
		
		var sort = "<?php if(!empty($oldsort) && $oldsort[0] == '1') { echo $oldsort[0]; } ?>";
        var sendData = '&content='+content+'&sort='+sort;
		
			<?php if (!empty($oldhashtags)) { foreach ($oldhashtags as $hashtag):?>
				sendData = sendData + '&hashtags[]=' + '<?php echo $hashtag->id;?>';
			<?php endforeach; } ?>
		
		$("#loadmorebutton").click(function (){
		    $('#loadmorebutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
			$.ajax({
				url: '{{ URL::to('loadmoreposts') }}',
				type: 'POST',
				data: 'lastpost='+ID+sendData,
				dataType: 'html',
				success: function(data){
					if(data){
						$("#postswrapper").append(data);
						console.log(data);
						ID = $(".postitem:last").attr("id");
						$('#loadmorebutton').html('<button type="button" class="btn btn-default">Load more...</button>');
						bindUpvoteListener();
					}else{
						$('#loadmorebutton').replaceWith('<center>No more posts to show.</center>');
					}
				}
			});
		});

	</script>
@stop