@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
@stop

@section('title')
	CS CONNECT.
@stop

@section('content')
	<style>
		/* tell the SVG path to be a thin blue line without any area fill */
		path {
			stroke: steelblue;
			stroke-width: 1;
			fill: none;
		}

		.axis {
		  shape-rendering: crispEdges;
		}

		.x.axis line {
		  stroke: lightgrey;
		}

		.x.axis .minor {
		  stroke-opacity: .5;
		}

		.x.axis path {
		  display: none;
		}

		.y.axis line, .y.axis path {
		  fill: none;
		  stroke: #000;
		}
		
		.x.label {
			text: "asljdkas";
		}
		
		.y.label {
			text: "asljdkas";
		}
	</style>
	{{ HTML::script('assets/js/d3.min.js') }}
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
			<h2 style="text-align: center">Analytics</h2>
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-12">
	    	<div class="well">
		    	<h2 style="text-align: center">Users Over Time</h2>
		    	Time: {{{date('m/d/Y',time() - 60*60*24*7*2)}}} to Time: {{{date('Y-m-d H:i:s')}}}
			<br>
			
			<div id="graph" class="aGraph" ></div>
			<script>
				// define dimensions of graph
				var m = [80, 80, 80, 80]; // margins
				var w = 600 - m[1] - m[3]; // width
				var h = 400 - m[0] - m[2]; // height
				
				// create a simple data array that we'll plot with a line (this array represents only the Y values, X will just be the index location)
				// This does 14 separate db queries, this needs to be optimized later
				var data = [];
				@for ($i = 60*60*24*7*2; $i > 0; $i -= 60*60*24)
					data.push({{{ User::where('created_at', '<=', date('Y-m-d H:i:s',time() - $i))->count() }}});
				@endfor

				var test = ["12/2" , "12/2" , "12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2" ,"12/2"];
				//Users::where('timestamp', '>=', time() - (24*60*60))->count();
				var format = d3.time.format("%m/%d");
				console.log(format.parse("12/2"));
				// display all values
				// X scale will fit all values from data[] within pixels 0-w
				var x = d3.scale.linear().domain([0, data.length]).range([0, w]);
				// Y scale will fit values from 0-10 within pixels h-0 (Note the inverted domain for the y-scale: bigger is up!)
				var y = d3.scale.linear().domain([0, data[data.length-1]]).range([h, 0]);
					// automatically determining max range can work something like this
					// var y = d3.scale.linear().domain([0, d3.max(data)]).range([h, 0]);

				// create a line function that can convert data[] into x and y points
				var line = d3.svg.line()
					// assign the X function to plot our line as we wish
					.x(function(d,i) { 
						// return the X coordinate where we want to plot this datapoint
						return x(i); 
					})
					.y(function(d) { 
						// return the Y coordinate where we want to plot this datapoint
						return y(d); 
					})

				// Add an SVG element with the desired dimensions and margin.
				var graph = d3.select("#graph").append("svg:svg")
					  .attr("width", w + m[1] + m[3])
					  .attr("height", h + m[0] + m[2])
					  .append("svg:g")
					  .attr("transform", "translate(" + m[3] + "," + m[0] + ")");

				// create yAxis
				var xAxis = d3.svg.axis().scale(x).tickSize(-h).tickSubdivide(true);
				// Add the x-axis.
				graph.append("svg:g")
					  .attr("class", "x axis")
					  .attr("transform", "translate(0," + h + ")")
					  .call(xAxis);

				// create left yAxis
				var yAxisLeft = d3.svg.axis().scale(y).ticks(4).orient("left");
				// Add the y-axis to the left
				graph.append("svg:g")
					  .attr("class", "y axis")
					  .attr("transform", "translate(-25,0)")
					  .call(yAxisLeft);
				
				// Add the line by appending an svg:path element with the data line we created above
				// do this AFTER the axes above so that the line is above the tick-lines
				graph.append("svg:path").attr("d", line(data));
				//<div class="video-container"><iframe width="560" height="315" src="//www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe></div>
				graph.append("text")
			        .attr("y", h + (m[1] / 2))
			        .attr("x", w / 2)
			        .text("Date");

			    graph.append("text")
			    	.attr("transform", "rotate(-90)")
			        .attr("y", 0 - 60)
			        .attr("x", (-h / 2) - (m[0] / 2))
			        .text("Number of Users");
			</script>
		
		    </div>
	    </div>
	    <!-- <div class="col-md-6">
	    	<div class="well">
		    	<h2 style="text-align: center">Graph 2</h2>
		    	<img src="assets/img/sampleGraph.gif" style="max-width: 100%; max-height:100%">
		    </div>
	    </div> -->
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