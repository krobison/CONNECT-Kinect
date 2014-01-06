@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/d3.min.js') }}
	
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
@stop

@section('title')
	CS CONNECT.
@stop

@section('content')
    <div class="row">
		<div class="col-md-6">
			<div class="">
				<h2>Welcome to CS CONNECT!</h2>
				<p>This website was created to provide a platform for personal networking across computer science at Mines. 
				If you have any questions, comments, concerns, etc. about the site please let me know by posting below or by emailing me
				(thbrown@mines.edu). <br> -- Thomas Brown (MS Computer Science)</p>
			</div>
		</div>
	    <div class="col-md-6">
	    	<div style="margin-top: 10px" class="panel panel-info">
				<div class="panel-heading">
					<h3>Site Updates</h3>
				</div>
				<div class="panel-body">
					<ul class="list-group">
					  <li class="list-group-item">1/8/2014 - Launch!</li>
					  <li class="list-group-item">1/5/2014 - Fixed layout/styling bug in the user profile. </li>
					  <li class="list-group-item">1/4/2014 - New posts on the newsfeed page are now loaded via AJAX. </li>
					  <li class="list-group-item">1/2/2014 - Added notifications for new conversations. </li>
					</ul>
				</div>
			</div>
	    </div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3>Site Usage Statistics</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h4><u> By the numbers </u></h4>
							<div>
								<p>
								Total Number of Users: {{{User::count()}}} <br>
								Total Number of Posts: {{{Post::count()}}} <br>
								Total Number of Comments: {{{Comment::count()}}} <br>
								Total Number of Upvotes: {{{Upvote::count()}}} <br>
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div>

								<h4><u> CS Connect Accounts </u></h4>
								Time: {{{date('Y-m-d H:i:s',time() - 60*60*24*7*2)}}} to Time: {{{date('Y-m-d H:i:s')}}}
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

									//Users::where('timestamp', '>=', time() - (24*60*60))->count();

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
										.text("Time");

									graph.append("text")
										.attr("transform", "rotate(-90)")
										.attr("y", 0 - 60)
										.attr("x", (-h / 2) - (m[0] / 4))
										.text("Users");
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3>Give Feedback</h3>
				</div>
				<div class="panel-body">
					{{ Form::open(array('url' => 'giveFeedback', 'method'=>'post')) }}
			
					
					<div style="float:left; padding-right: 10px">
						Leave us some feedback on CS Connect (Bug, Like, Dislike, Comment, Feature Request etc...)
						<br>
						<br>
						You are posting publicly as {{{Auth::user()->first}}} {{{Auth::user()->last}}}
					</div>

					{{ Form::textarea('content', null, array('class' => 'span4' ,'placeholder' => 'Enter your comment here','id' => 'comment-box')) }}

					{{ Form::hidden('user_id', $user->id) }}

					{{ Form::submit('Submit', array('class' => 'btn btn-lg btn-primary btn-block')) }}

					{{ Form::close() }}
				</div>
			</div>
		</div>

	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3>All Feedback</h3>
				</div>
				<div class="panel-body">
					@foreach ($posts as $post)
						{{ View::make('common.newsfeedPost')->with('post', $post) }}
					@endforeach
				</div>
			</div>
	    </div>
	</div>
	
@stop