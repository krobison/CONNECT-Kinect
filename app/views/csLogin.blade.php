<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/signin.css') }}
	{{ HTML::style('app/views/css/social-buttons.css') }}
	{{ HTML::style('assets/css/font-awesome.min.css') }}

</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-krobison/img/Connect_Logo.png">
	</div>
	<div class="content">
		<div class="container" id="signmein">
			<form class="form-signin">
				<h2 class="form-signin-heading" id="welcome">Welcome to CS CONNECT!</h2>
				<input type="text" class="form-control" placeholder="Username" required autofocus>
				<input type="password" class="form-control" placeholder="Password" required>
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> Remember me
				</label>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			</form>
		<hr class="separatron">
		</div>
		<div class="container" id="signmein">
			<form class="form-signin">
				<h2 class="form-signin-heading" id="registernow">Register Today!</h2>
					<button class="btn btn-lg btn-primary btn-block" type="submit" id="newuserbutton">Create New Account</button>
				<!--<div class="orseparator">
					<span class="label label-info">Or</span>
				</div>-->
				<div class="connectbuttons">
					<button class="btn btn-facebook"><i class="fa fa-facebook"></i> | Connect</button>
					<button class="btn btn-twitter"><i class="fa fa-twitter"></i> | Connect</button>
				</div>
			</form>
		</div>
		<div class="container" id="video">
			<iframe width="420" height="315" src="http://www.youtube.com/embed/qb_hqexKkw8?rel=0" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<p class="text-muted credit">©2013 Toilers research group, Colorado School of Mines <img src="http://toilers.mines.edu/csconnect-krobison/img/mines_logo.png" id="mineslogo"> <img src="http://toilers.mines.edu/csconnect-krobison/img/toilers.png"> </p>
		</div>
	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>