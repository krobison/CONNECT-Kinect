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