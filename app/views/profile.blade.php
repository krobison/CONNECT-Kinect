
<!DOCTYPE html>
<html>
	<head>
		<title>CONNECT - Profile</title>

		{{ HTML::style('css/LayoutGlobal.css') }}
		{{ HTML::style('css/LayoutLoggedIn.css') }}
		{{ HTML::style('css/LayoutMenu.css') }}
		{{ HTML::style('css/LayoutNoSidebar.css') }}
		
		{{ HTML::script('js/log.js') }}

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		{{ HTML::style('css/LayoutProfile.css') }}
		{{ HTML::style('css/LayoutPeopleViewer.css') }}

		{{ HTML::script('js/limittext.js') }}
		{{ HTML::script('js/disablestate.js') }}

	</head> 

	<body>
	
		{{ View::make('common.header') }}

		{{ View::make('common.menu') }}

		<div id="main">
			
			<div id="content">
					
				{{ View::make('common.message') }}
				
				{{ View::make('common.validationErrors') }}
				
				
	<div class="content_section">
		<h2>Your Profile:</h2>

		{{ View::make('common.person')->with('user', $user) }}

	</div>



		<div id="left_column">	
			<div id="general_info">
	<div class="content_section">
		<h2>General Information</h2>
		
		{{ Form::open(array(
			'url' => 'profile',
			'method' => 'put',
			'files' => 'true')) }}
			
			{{ Form::hidden('id', $user->id) }}

			{{ Form::label('first_name', 'First Name: *') }}
			{{ Form::text('first_name', $user->first_name) }}
			
			{{ Form::label('last_name', 'Last Name: *') }}
			{{ Form::text('last_name', $user->last_name) }}
			
			{{ Form::label('email', 'Email: *') }}
			{{ Form::text('email', $user->email) }}

			{{ Form::label('organization', 'Organization:') }}
			{{ Form::text('organization', $user->organization) }}
			
			{{ Form::label('state', 'State:') }}
			{{ Form::select('state', array(
				'' => 'Select a State',
				'AL' => 'Alabama',  
				'AK' => 'Alaska',  
				'AZ' => 'Arizona',  
				'AR' => 'Arkansas',  
				'CA' => 'California',  
				'CO' => 'Colorado',  
				'CT' => 'Connecticut',  
				'DE' => 'Delaware',  
				'DC' => 'District Of Columbia',  
				'FL' => 'Florida',  
				'GA' => 'Georgia',  
				'HI' => 'Hawaii',  
				'ID' => 'Idaho',  
				'IL' => 'Illinois',  
				'IN' => 'Indiana',  
				'IA' => 'Iowa',  
				'KS' => 'Kansas',  
				'KY' => 'Kentucky',  
				'LA' => 'Louisiana',  
				'ME' => 'Maine',  
				'MD' => 'Maryland',  
				'MA' => 'Massachusetts',  
				'MI' => 'Michigan',  
				'MN' => 'Minnesota',  
				'MS' => 'Mississippi',  
				'MO' => 'Missouri',  
				'MT' => 'Montana',
				'NE' => 'Nebraska',
				'NV' => 'Nevada',
				'NH' => 'New Hampshire',
				'NJ' => 'New Jersey',
				'NM' => 'New Mexico',
				'NY' => 'New York',
				'NC' => 'North Carolina',
				'ND' => 'North Dakota',
				'OH' => 'Ohio',  
				'OK' => 'Oklahoma',  
				'OR' => 'Oregon',  
				'PA' => 'Pennsylvania',  
				'RI' => 'Rhode Island',  
				'SC' => 'South Carolina',  
				'SD' => 'South Dakota',
				'TN' => 'Tennessee',  
				'TX' => 'Texas',  
				'UT' => 'Utah',  
				'VT' => 'Vermont',  
				'VA' => 'Virginia',  
				'WA' => 'Washington',  
				'WV' => 'West Virginia',  
				'WI' => 'Wisconsin',  
				'WY' => 'Wyoming'
				), $user->state) }}
			
			{{ Form::label('city', 'City:') }}
			{{ Form::text('city', $user->city) }}
			
			{{ Form::label('webpage', 'Webpage:') }}
			{{ Form::text('webpage', $user->webpage) }}

			<br /><br />
			{{ Form::submit('Update') }}
		


		<div class="clear">
		</div>
	</div>
</div>

	<div class="content_section">
		<h2>Update Profile Picture</h2>
		{{ Form::file('image') }} {{ Form::submit('Update') }}
	</div>

	<div class="content_section">
		<h2>Roles</h2>
		@foreach ($roles = Role::all() as $role)
			<p>
			@if ($user->roles->contains($role->id))
				{{ Form::checkbox('roles[]', $role->id, 'true') }}
			@else
				{{ Form::checkbox('roles[]', $role->id) }} 
			@endif
			{{ $role->name }}
			</p>
		@endforeach
		{{ Form::submit('Update') }}
	</div>


		</div>

		<div id="right_column">
			<div id="about">
	<div class="content_section">
		<h2>About</h2>
		
		<textarea name="about" id="about"
				onKeyDown="limitText(this.form.about, this.form.countdown, 500);" 
				onKeyUp="limitText(this.form.about, this.form.countdown, 500);">{{ $user->about }}</textarea>
		<div class="limit_text_counter">
			(Maximum characters: 500). You have 
			<input readonly type="text" name="countdown" size="3" value="{{ 500 - strlen($user->about) }}" /> 
			characters left.
		</div>

		{{ Form::submit('Update') }}
		
	</div>
</div>

	<div class="content_section">
		<h2>Interest Areas</h2>
		@foreach ($interests = Interest::all() as $interest)
			<p>
			@if ($user->interests->contains($interest->id))
				{{ Form::checkbox('interests[]', $interest->id, 'true') }}
			@else
				{{ Form::checkbox('interests[]', $interest->id) }}
			@endif
			{{ $interest->name }}
			</p>
		@endforeach
		{{ Form::submit('Update') }}
		{{ Form::close() }}
	</div>
		
		</div>


	<div class="clear">
	</div>

	<div class="content_section" style="text-align: right">
		{{ Form::open(array(
			'url' => 'deleteUser',
			'method' => 'delete' 
			)) }}
		{{ Form::hidden('id', $user->id) }}
		{{ Form::submit('Opt-out of CONNECT') }}
		{{ Form::close() }}

		<div class="clear">
		</div>
	</div>

			</div>
		</div>

		{{ View::make('common.footer') }}

	</body>

</html>
