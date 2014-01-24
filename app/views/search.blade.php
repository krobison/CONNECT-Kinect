@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::style('assets/css/search.css') }}
	<style>
	#search-title:hover
	{ 
		background-color:orange;
	}
	</style>
@stop

@section('title')
	USER SEARCH.
@stop

@section('content')
	<h2> User Search Page </h2>
	<div class="panel panel-default">
	    <div id="search-title" class="panel-heading">
			<h4>
			Search
			</h4>
		</div>
		<div id="new-post-body" class="panel-body">
		<div class="form-group">
		
		{{ Form::open(array('url' => 'searchfilter', 'method' => 'GET')) }}
		<div style="width:100%;">
		@if(!empty($name))
		{{ Form::text('name', $name, array( 
		'placeholder' => 'Search for users by name and bio',
		'class' => 'form-control'
		)) }}
		@else
		{{ Form::text('name', null, array( 
		'placeholder' => 'Search for users by name and bio',
		'class' => 'form-control'
		)) }}
		@endif
		</div>
		</div>
		<div class="form-group">
				<select multiple style="width:100%;" class="select2-container classSelect" name="hashtags[]">
					<optgroup label="Hashtags">
						@foreach(Hashtag::all() as $hashtag)
							<option value={{ $hashtag->id }}>{{ $hashtag->name }}</option>
						@endforeach
					</optgroup>
					@if (!empty($searchHashtags))
							@foreach($searchHashtags as $hashtag)
								<option selected value={{{ $hashtag->id }}}>
									{{{ $hashtag->name }}}
								</option>
							@endforeach
					@endif
				</select>
		</div>
		
		<div class="row">
			<div class ="col-xs-5 col-md-4">
				{{Form::submit('Search', array('class' => 'btn btn-primary btn-block'))}}	
				{{ Form::close() }}
			</div>
			<div class ="col-xs-4 col-md-3">
				<a href="{{URL::to('showallusers')}}">
				<button class="btn btn-primary btn-block">Show all users</button>
				</a>
			</div>
		</div>
		
		
		</div>
	</div>
	
	@if(isset($nameresults))
		@if(!empty($nameresults))
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Matching Names </h4>
			</div>
			<div id="name-body" class="panel-body">
				<div id="nameresultswrapper">
					{{ View::make('loadmoreusers')
							->with('user', Auth::user())
							->with('results', $nameresults)
							->with('type', 'name') }}
				</div>
				<div id="loadmorenameresultsbutton" style="text-align:center">
					<button type="button" class="btn btn-default">Load more...</button>
				</div>
			</div>
		</div>
		@endif
	@endif
	
	@if(isset($bioresults))
		@if(!empty($bioresults))
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Matching Bios</h4>
			</div>
			<div id="bio-body" class="panel-body">

				<div id="bioresultswrapper">
					{{ View::make('loadmoreusers')
							->with('user', Auth::user())
							->with('results', $bioresults)
							->with('type', 'bio')}}
				</div>
	
				<div id="loadmorebioresultsbutton" style="text-align:center">
					<button type="button" class="btn btn-default">Load more...</button>
				</div>
			</div>
		</div>
		@endif
	@endif
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	<script>
		$(document).ready(function() { 
		$(".select2-container").select2({
			placeholder: " Search for users by the hashtags they are subscribed to"
		});
		});
		
		var namesLoaded = $(".numNames").length;
		var biosLoaded = $(".numBios").length;
		var numberOfUsersToLoad = 5;
		var nameUrl = '{{ URL::to("loadmorenameresults") }}';
		var bioUrl = '{{ URL::to("loadmorebioresults") }}';
		var name = "<?php if(!empty($name)) {echo $name;} ?>"
		var hashtags = "";
		<?php if (!empty($searchHashtags)) { foreach ($searchHashtags as $hashtag):?>
			hashtags = hashtags + '&hashtags[]=' + '<?php echo $hashtag->id;?>';
		<?php endforeach; } ?>

		$("#loadmorenameresultsbutton").click(function (){
            $('#loadmorenameresultsbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
			morePosts(numberOfUsersToLoad,namesLoaded,nameUrl,1);
        });

        $("#loadmorebioresultsbutton").click(function (){
            $('#loadmorebioresultsbutton').html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
			morePosts(numberOfUsersToLoad,biosLoaded,bioUrl,0);
        });
			
		var morePosts = function(count,offset,route,isName) {
			$.ajax({
				url: route,
				type: 'POST',
				data: 'lastpost='+offset+'&toLoad='+count+'&name='+name+hashtags,
				success: function(data){
					if(data){
							if(isName == 1) {
								$("#nameresultswrapper").append(data);
								namesLoaded = $(".numNames").length;
								$('#loadmorenameresultsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
							} else {
								$("#bioresultswrapper").append(data);
								biosLoaded = $(".numBios").length;
								$('#loadmorebioresultsbutton').html('<button type="button" class="btn btn-default">Load more...</button>');
							}
					}else{
						if(isName == 1) {
							$('#loadmorenameresultsbutton').replaceWith('<center>No more users to show.</center>');
						} else {
							$('#loadmorebioresultsbutton').replaceWith('<center>No more users to show.</center>');
						}
					}
				},
				timeout: 6000,
				error: function(x, t, m){ 
					$('#loadmoreprojectsbutton').replaceWith('<center>The request to load more users is taking too long, please try again later.</center> <br> <button type="button" class="btn btn-default">Load more...</button>');
				}
			});
		}

		/* Hide and show post divs on button press
		$('#search-title').click(function() {
			$('#new-post-body').toggle(200);
		});
		$('#hide-name-button').click(function() {
			$('#name-body').toggle(200);
		});
		$('#hide-bio-button').click(function() {
			$('#bio-body').toggle(200);
		});*/
	</script>
@stop