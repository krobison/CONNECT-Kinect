
<!DOCTYPE html>
<html>
	<head>
	
		<title>CONNECT - Login</title>

		{{ HTML::style('css/LayoutGlobal.css') }}
		{{ HTML::style('css/LayoutLogin.css') }}
		{{ HTML::style('css/LayoutNoSidebar.css') }}
		{{ HTML::script('js/log.js') }}
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		{{ HTML::style('css/LayoutStartPage.css') }}
		{{ HTML::style('js/toggle_visibility.js') }}
	
	</head> 

	<body>

	{{ View::make('common.header') }}

		<div id="menu_bar" style="text-align: right; color: white">

		{{ Form::open(array(
			'url' => 'login')) }}

			{{ Form::label('email', 'Email:') }}
			{{ Form::text('email') }}

			{{ Form::label('password', 'Password:') }}
			{{ Form::password('password') }}

			{{ Form::submit('Login') }}

		{{ Form::close() }}

		</div>

		<div id="main">
			
			<div id="content">
			
				{{ View::make('common.message') }}

	<div class="content_section">
		<h1>Welcome!</h1>
		<h2>What is CONNECT?</h2>
		CONNECT provides conferences a searchable online attendee list.
		CONNECT participants are able to:
		<ol>
			<li>Search the directory for other attendees with similar interests, </li>
			<li>View a list of people that the system suggests you might want to meet at the conference, </li>
			<li>Send messages to people you want to meet, and </li>
			<li>View the conference schedule, also available as an Android app on 
				<a href="https://play.google.com/store/apps/details?id=edu.mines.CONNECT_Grad_Cohort_2013" target="_blank">Google Play</a>
			</li>
		</ol>
	</div>

	<div class="content_section">
		<h2>How do I use CONNECT?</h2>

		<p>Use the 4-Character ID and password that you received in the Welcome email to log in. If you need to change your password, click Login and then the Reset password link.</p>

		<p>CONNECT allows you to search for and send messages to other meeting attendees. You will be able to return to the CONNECT site after the meeting to remember who you talked to (uploading photos really helps everyone). If you did not upload a photo or enter a bio, please do that now so that other meeting participants can find you.</p>

		<p>For more information about CONNECT, see our <a href="../FAQ?not_logged_in">Frequently Asked Questions.</a></p>
	</div>

			</div>
		</div>

		{{ View::make('common.footer') }}

	</body>

</html>
