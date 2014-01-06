<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/signin.css') }}
	{{ HTML::style('assets/css/social-buttons.css') }}
	{{ HTML::style('assets/css/font-awesome.min.css') }}
	
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
		
</head>

{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}

<body>
	<div class="content">
		<!--
		<div id="rightPanel">
		
			<h3> CS Connect Accounts </h3>
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
			        .text("Value");

			    graph.append("text")
			    	.attr("transform", "rotate(-90)")
			        .attr("y", 0 - 60)
			        .attr("x", (-h / 2) - (m[0] / 4))
			        .text("Value2");
			</script>
		

		</div> -->
		<div id="header"> 
			{{ HTML::image('assets/img/Connect_Logo.png' , '', array('class' => 'logo')) }}
		</div>
			<div class="buttonRow">
				<button type="button" class="btn btn-lg btn-primary btn-block" id="enter" style="float:left;">
					 Enter
				</button>
				{{ Form::open(array('url' => 'signup','method' => 'get','class' => 'form-signin')) }}
						<div class="button-div">
							<button type="submit" class="btn btn-lg btn-primary btn-block" style="float:right;">
								<span class="glyphicon glyphicon-user"></span> Create Account
							</button>
						</div>			
					{{ Form::close() }}
			</div>
			<div id="header2"> 
				<div id="signinpanel" class="panel panel-default" style="margin-top:-250px;"><br><br>
					<script>$('#signinpanel').toggle(100);</script>
					{{ Form::open(array('url' => 'loginuser','class' => 'form-signin')) }}
						
						{{ Form::text('email', '', array('class' => 'form-control','placeholder' => 'Email','autofocus' => 'true')) }}
						{{ Form::password('password', array('class' => 'form-control','placeholder' => 'Password')) }}
															
						<!--<label class="checkbox" style="text-align:left;">
							<input type="checkbox" value="remember-me"> Remember me <i> Not Working </i>
						</label>-->
						<a href="{{asset('password/reset')}}" style="color:white;"><i>I forgot my password</i></a><br><br>
							
						<div class="button-div">
							<button type="submit" class="btn btn-lg btn-primary btn-block">
								<span class="glyphicon glyphicon-log-in"></span> Sign In
							</button>
						</div><br><br>
					{{ Form::close() }}
				</div>
			</div>
		</div>
		<div id="footer">
			<div class="container" style="text-align:left;">
				<article class="boxed">
				    <ul class="feature-box nolist">
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-list" style="color:#1478Bb;"> <a title="NewsFeed">Newsfeed</a></h2>
				            <p>Use the Newsfeed to keep up-to-date with other students and classes.</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-user" style="color:#1478Bb;"> <a title="Customizable_Profile">Customizable_Profile</a></h2>
				            <p>CS-CONNECT gives you the ability to customize your profile by embedding safe HTML tags. You can learn more about your classmates by viewing their profiles.</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-question-sign" style="color:#1478Bb;"> <a title="CS _Question">CS_Question</a></h2>
				            <p>With CS Question, you can see challenging Computer Science questions and other students' answers to them, as well as attempt to tackle them yourself.</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-hdd" style="color:#1478Bb;"> <a title="CS_Projects">CS_Projects</a></h2>
				            <p>Upload your own projects for the CS CONNECT community to see, or browse the projects that others have submitted</p><br>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-bullhorn" style="color:#1478Bb;"> <a title="Help_Center">Help_Center</a></h2>
				            <p>With the Help Center, you can ask help from your fellow students, set up meeting times and places, and offer help to others. You can even ask for help anonymously!</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-envelope" style="color:#1478Bb;"> <a title="Conversations">Conversations</a></h2>
				            <p>Send messages to others with CS-CONNECT's built-in messaging system. Manage your conversations and message groups of people all at once.</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-search" style="color:#1478Bb;"> <a title="Search">Search</a></h2>
				            <p>Search for other users in your classes, search for your friends, search for posts with specific content, search for anything!</p>
				        </li>
				        <li class="one_quarter">
				            <h2><span class="glyphicon glyphicon-tag style="color:#1478Bb;"" style="color:#1478Bb;"> <a title="Hastags">Hashtags</a></h2>
				            <p>Subscribe to tags that you like and get notified when new posts are made with that tag! Easily and quickly find the content that you are looking for.</p>
				        </li>
				    </ul>
				</article>
				<p class="text-muted credit"  style="margin-top:350px;margin-bottom:64px;text-align:center;">©2013 Toilers research group, Colorado School of Mines 
					{{ HTML::image('assets/img/mines_logo.png') }}
					{{ HTML::image('assets/img/toilers.png') }}
				</p>
			</div>
		</div>
	</div>
	<!-- Loading all scripts at the end for performance-->
	<script>
		// Hide and show post divs on button press

		$('#enter').click(function() {
		$('#signinpanel').toggle(200);
		});

		$('#signup').click(function() {
		$('#registerpanel').toggle(200);
		});

	</script>
</body>
</html>