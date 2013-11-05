
<!DOCTYPE html>
<html>
	<head>
		<title>CONNECT - Home</title>

		{{ HTML::style('css/LayoutGlobal.css') }}
		{{ HTML::style('css/LayoutLoggedIn.css') }}
		{{ HTML::style('css/LayoutMenu.css') }}
		{{ HTML::script('js/log.js') }}

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		{{ HTML::style('css/LayoutWelcome.css') }}

	</head> 

	<body>
	
		{{ View::make('common.header') }}

		{{ View::make('common.menu') }}

		<div id="main">
		
		{{ View::make('common.sidebar') }}
			
			<div id="content">
				<div id="flash">
														</div>

				
	<div class="content_section">
		<h1>Welcome!</h1>
		<h2>How to get the most value from CONNECT</h2>
		<ol>
			<li class="ordered">Go to your 
				<a href="../../modules/profile/">Profile</a> 
				page to edit or update your information. Adding a picture 
				will help other people recognize you and adding your website 
				or Facebook URL will help others find you after the conference is over.
			</li>
			<li class="ordered">Go to the 
				<a href="../../modules/search/">People</a> 
				page to search for other conference attendees.
				<ul>
					<li>Identify people you want to meet</li>
					<li>Remember people you met.</li>
					<li>Send a message to another conference attendee.</li>
				</ul>
			</li>
			<li class="ordered">Go to the 
				<a href="../../modules/goals">Goals</a> 
				page where you can select appropriate goals, 
				read the tips, and practice your networking skills.
			</li>
			<li class="ordered">Go to the 
				<a href="../../modules/community">Community</a> 
				page and review the social networks related to your interest areas. 
				To increase your own network, send some messages or 
				identify people you want to meet on the People page.
			</li>
			<li class="ordered">Go to the 
				<a href="../../modules/schedule">Schedule</a> page to see the
				entire conference schedule and select events to attend.
			</li>
		</ol>

		<p>For more information about CONNECT, see our <a href="../../modules/FAQ/">Frequently Asked Questions.</a></p>
	</div>

	<div class="content_section">   
		<h2>Download the CONNECT mobile app:</h2>
		<p>You can easily keep track of your conference schedule and goals on the CONNECT
			Grad Cohort 2013 mobile application, available on  
			<a href="https://play.google.com/store/apps/details?id=edu.mines.CONNECT_Grad_Cohort_2013" target="_blank">Google Play</a>.
			You can view the entire conference schedule, so you'll always know when and where you need to be.
			You can also manage your goals, read networking tips on the go, and keep track of your
			networking progress during the conference.
		</p>
	</div>

	<div class="content_section">
		<h2>Look for CONNECT at the following upcoming conference(s):</h2>
		<h1 class="conference_name">Grad Cohort 2013</h1>
		{{ HTML::image('img/grad-cohort.png') }}
	</div>

			</div>
		</div>

		{{ View::make('common.footer') }}

	</body>

</html>
