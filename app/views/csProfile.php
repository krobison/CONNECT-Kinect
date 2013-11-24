<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/profile.css') }}
	{{ HTML::style('app/views/css/social-buttons.css') }}
	{{ HTML::style('assets/css/font-awesome.min.css') }}

</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-krobison/img/Connect_Logo.png">
	</div>
	<div class="content">
		<div class="container" id="signmein">
			
	</div>
	<div id="footer">
		<div class="container">
			<p class="text-muted credit">©2013 Toilers research group, Colorado School of Mines <img src="http://toilers.mines.edu/csconnect-krobison/img/mines_logo.png" id="mineslogo"> <img src="http://toilers.mines.edu/csconnect-krobison/img/toilers.png"> </p>
		</div>
	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>