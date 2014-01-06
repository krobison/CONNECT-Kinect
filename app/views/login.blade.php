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
			<div>
				<?php $message = Session::get('message');?>
				@if ($message)
					{{$message}}
				@endif
			</div>
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
				<p class="text-muted credit"  style="margin-top:350px;margin-bottom:64px;text-align:center; color:#000000">©2013 Toilers research group, Colorado School of Mines 
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