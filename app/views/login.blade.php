<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/signin.css') }}
	{{ HTML::style('assets/css/social-buttons.css') }}
	{{ HTML::style('assets/css/font-awesome.min.css') }}
	
	{{ HTML::script('assets/js/d3.min.js') }}
		
</head>

{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}

<body>
	<div class="content">
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
						<a href="{{asset('password/reset')}}" style="color:red;"><i>I forgot my password</i></a><br><br>
							
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
			<div class="container">
				<p class="text-muted credit"  style="margin-top:350px;margin-bottom:64px;">©2013 Toilers research group, Colorado School of Mines 
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