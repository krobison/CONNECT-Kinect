@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
@stop

@section('title')
	CS CONNECT.
@stop

@section('content')
	<div class="page-header">
		<div class="well well-sm">
			<h2>Welcome!</h2>
        	<p>Here is where features can be listed as well as about information</p>
    	</div>
    </div>
    <div class="row">
	    <div class="col-md-12">
	    	<div class="well">
			    <h2>Updates</h2>
		    	<ul class="list-style">
				  <li>Messaging</li>
				  <li>Posting</li>
				  <li>Commenting</li>
				  <li>Pretty Much Everything</li>
				</ul>
			</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h2 style="text-align: center">Some Cool Graphs</h2>
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-6">
	    	<div class="well">
		    	<h2 style="text-align: center">Graph 1</h2>
		    	<img src="assets/img/sampleGraph.gif" style="max-width: 100%; max-height:100%">
		    </div>
	    </div>
	    <div class="col-md-6">
	    	<div class="well">
		    	<h2 style="text-align: center">Graph 2</h2>
		    	<img src="assets/img/sampleGraph.gif" style="max-width: 100%; max-height:100%">
		    </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-12">
	    	<div class="well">
		    	<h2 style="text-align: center">Give Feedback</h2>
		    	{{ Form::open(array('url' => 'giveFeedback', 'method'=>'post')) }}
		
				<div style="float:left; padding-right: 10px">
					@if(is_null(Auth::user()->picture))
						{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
					@else
						@if ( File::exists('assets/img/profile_images/' . Auth::user()->picture ))
							{{ HTML::image('assets/img/profile_images/'.Auth::user()->picture, 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
						@else
							{{ HTML::image('assets/img/dummy.png', $user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
						@endif
					@endif 
				</div>

				{{ Form::textarea('content', null, array('class' => 'span4' ,'placeholder' => 'Enter your comment here','id' => 'comment-box')) }}

				{{ Form::hidden('user_id', $user->id) }}

				{{ Form::submit('Submit', array('class' => 'btn btn-lg btn-primary btn-block')) }}

				{{ Form::close() }}
		    </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-12">
	    	<h3 style="text-align: center">Previous Feedback</h3>
	    	@foreach ($posts as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
			@endforeach
	    </div>
	</div>
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
@stop