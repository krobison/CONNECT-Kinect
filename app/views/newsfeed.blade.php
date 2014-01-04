@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/posts.css') }}
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
	    {{ View::make('common/createPost')->with('url', 'creategeneralpost') }}
	</div>
	
	<!-- Search posts functionality -->
	<div class="panel panel-default">
	    <div class="panel-heading">
			<h4>
			Search Posts
			<div class="btn-group" id="new-search-buttons">
				<button id="hide-search-post-button" type="button" class="btn btn-default btn-sm">Hide</button>
			</div>
			</h4>
		</div>
		<div id="search-posts" class="panel-body">
		{{ Form::open(array('url' => 'searchposts', 'method' => 'GET')) }}
			<div class="form-group">
				<b>Upvotes</b> <br>
				<label class="checkbox-inline">
				{{ Form::checkbox('sort[]', '1') }}
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
				</select>
				<br><br>
				
				<b>Content</b> </br>
					<div class="form-group">
					{{ Form::textarea('content', null, array('id' => 'content-form',
							'class' => 'form-control',
							'placeholder' => 'Search for content within a post',
							'rows' => '5')) }}
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
	
	@foreach ($posts as $postid)
		<?php 
		$post = Post::find($postid->id)
		?>
		@if($post->postable_type != 'PostProject' || $post->postable->approved == '1')
			{{ View::make('common.newsfeedPost')->with('post', $post) }}
		@endif
	@endforeach
	
	<!-- Loading all scripts at the end for performance -->
	<script>

		// Hide and show post divs on button press
		$('#hide-new-post-button').click(function() {
			$('#new-post-body').toggle(200);
		});
		
		$('#hide-search-post-button').click(function() {
			$('#search-posts').toggle(200);
		});
		
		$(document).ready(function() { 
			$(".select2-container-hashtagsearch").select2({
				placeholder: "Select Hashtags"
			});		
		});

	</script>
@stop