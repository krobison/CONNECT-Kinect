<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/profile.css') }}

</head>

<body>
	<div class="page-header">
		{{ HTML::image('assets/img/Connect_Logo.png') }}
	</div>

	<div class="content"> 
		<div class="basic">
			<div class="picture">
				{{ HTML::image('assets/img/dummy.png') }}
			</div>
			<div class="info">
				<h3>Basic Information</h3>
				<span class="infolabel">Name:</span>
					<span>Darth Vader</span><br>
				<span class="infolabel">Degree:</span>
					<span>Bachelors</span><br>
				<span class="infolabel">Graduation Date:</span>
					<span>May 2015</span><br>
				<span class="infolabel">Major:</span>
					<span>Computer Science</span><br>
				<span class="infolabel">Minor:</span>
					<span>BELS , Energy</span><br>
			</div>
			<div class="courses">
				<h3>Courses</h3>
					<span class="courselabel">CSCI406 - Algorithms</span>
					<span class="courselabel">CSCI306 - Software Engineering</span>
					<span class="courselabel">CSCI404 - Aritificial Intelligence</span>
					<span class="courselabel">CSCI445 - Web Programming</span>
					<span class="courselabel">CSCI358 - Discrete Mathematics</span>
			</div>
		</div>
		<div class="custom">
		</div>
	</div>
	
	<div id="footer">
		<div class="container">
			<p class="text-muted credit">©2013 Toilers research group, Colorado School of Mines 		{{ HTML::image('assets/img/mines_logo.png') }}	{{ HTML::image('assets/img/toilers.png') }} </p>
		</div>
	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>