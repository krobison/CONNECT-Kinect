@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/posts.css') }}
@stop

@section('title')
	NEWSFEED.
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
                            ID = $(".postitem:last").attr("id");
							 $('#loadmorebutton').html('<button type="button" class="btn btn-default">Load more...</button>');
                        }else{
                            $('#loadmorebutton').replaceWith('<center>No more posts to show.</center>');
                        }
                    }
					
                });
            });
			
		
	

	</script>
@stop