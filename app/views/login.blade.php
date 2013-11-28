<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/signin.css') }}
	{{ HTML::style('assets/css/social-buttons.css') }}
	{{ HTML::style('assets/css/font-awesome.min.css') }}
</head>

<body>
	<div class="page-header">
		{{ HTML::image('assets/img/Connect_Logo.png') }}
	</div>
	
	<div class="span6" style="text-align:center">
	@if(Session::has('message'))	
		<p> {{Session::get('message');}} </p>
	@endif
	</div>	
	
	<div class="content">
		<div class="container" id="signmein">
		
		{{ Form::open(array('url' => 'loginuser',
							'class' => 'form-signin')) }}
			
				<h2 class="form-signin-heading" id="welcome">Welcome to CS CONNECT!</h2>
				
				{{ Form::text('email', '', array('class' => 'form-control',
											     'placeholder' => 'Email',
											     'autofocus' => 'true')) }}
				{{ Form::password('password', array('class' => 'form-control',
													'placeholder' => 'Password')) }}
													
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> Remember me
				</label>
				
				{{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-primary btn-block')) }}
				
		{{ Form::close() }}
		
		<hr class="separatron">
		</div>
		<div class="container" id="signmein">
		
			{{ Form::open(array('url' => 'signup',
								'method' => 'get',
								'class' => 'form-signin')) }}
									
				<h2 class="form-signin-heading" id="registernow">Register Today!</h2>
			
				{{ Form::submit('Create New Account', array('class' => 'btn btn-lg btn-primary btn-block')) }}
				
				<br>
				
				<div class="connectbuttons">
					<button class="btn btn-facebook"><i class="fa fa-facebook"></i> | Connect</button>
					<button class="btn btn-twitter"><i class="fa fa-twitter"></i> | Connect</button>
				</div>
				
			{{ Form::close() }}
			
		</div>
		<div class="container" id="video">
			<iframe width="420" height="315" src="http://www.youtube.com/embed/qb_hqexKkw8?rel=0" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<p class="text-muted credit">©2013 Toilers research group, Colorado School of Mines 
				{{ HTML::image('assets/img/mines_logo.png') }}
				{{ HTML::image('assets/img/toilers.png') }}
			</p>
		</div>
	</div>
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
</body>
</html>