<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/csNewUser.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	<style>
		.checkbox-label {
			padding-left: 15px;
		}
		.select2-container {
			width: 100%;
			padding: 5px;
		}
	</style>
</head>

<body>
	<div id="main">
		<div class="logoheader">
			{{ HTML::image('assets/img/Connect_Logo.png') }}
		</div>	
		
		<div class="span6" style="text-align:center">
		@if(Session::has('message'))
			<p> {{Session::get('message');}} </p>
		@endif
		</div>	
		
		<div class="container">
		{{ Form::open(array('url' => 'signup', 'files' => true)) }}
		<div class="rowlabel">
			{{Form::label('name', 'Name', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}  
		</div>
		
		{{-- Name --}}
		<div class="row">
			<div class="col-xs-5 col-md-4 col-md-offset-2">
				{{Form::text('first', null, array(
					'id' => 'first-name',
					'class' => 'form-control',
					'placeholder' => 'First',
					'autofocus',
				))}}
			</div>
			<div class="col-xs-5 col-md-4">
				{{Form::text('last', null, array(
					'id' => 'last-name',
					'class' => 'form-control',
					'placeholder' => 'Last',
				))}}		
			</div>
		</div>
		@if($errors->has('first')||$errors->has('last'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2">
				{{$errors->first('first')}}
				{{$errors->first('last')}}
				</div>
			</div>
		@endif

		{{-- Email --}}
		<div class="rowlabel">
			{{Form::label('email', 'E-mail', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::text('email', null, array(
					'id' => 'email',
					'class' => 'form-control',
					'placeholder' => 'E-mail',
				))}}
			</div>
		</div>
		@if($errors->has('email'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2">
				{{$errors->first('email')}}
				</div>
			</div>	
		@endif

		{{-- Password --}}
		<div class="rowlabel">
			{{Form::label('password', 'Password', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::password('password', array(
					'id' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Password',
				))}}		
			</div>
		</div>
		@if($errors->has('password'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2">
				{{$errors->first('password')}}
				</div>
			</div>	
		@endif
		<div class="rowlabel">
			{{Form::label('password_confirmation', 'Password Confirm', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}	
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::password('password_confirmation', array(
					'id' => 'password-confirm',
					'class' => 'form-control',
					'placeholder' => 'Password Confirm',
				))}}		
			</div>
		</div>
		@if($errors->has('password_confirmation'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2">
				{{$errors->first('password_confirmation')}}
				</div>
			</div>	
		@endif
		
		{{-- Gender --}}
		<div class="rowlabel"> 
			{{Form::label('gender', 'Gender', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
			<ul class="list-inline">
			  <li> {{ Form::radio('gender', '0', false, array('id' => 'male')) }} Male  </li>
			  <li> {{ Form::radio('gender', '1', false, array('id' => 'female')) }} Female </li>
			  <li> {{ Form::radio('gender', '2', false, array('id' => 'pnr')) }} Prefer Not To Respond </li>
			</ul>
			</div>
		</div>
		
		{{-- Are you a student? --}}
		<div class="row">
			{{Form::label('student', 'Are you a student?', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
			<ul class="list-inline student_switch">
			  <li> {{ Form::radio('student', 'yes', false) }} Yes  </li>
			  <li> {{ Form::radio('student', 'no', true) }} No </li>
			</ul>
			</div>
		</div>

		<div id="student_panel" style="display: none">
			
			{{-- Degree Type --}}
			<div class="row">
				{{Form::label('degree_type', 'Degree Type', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{ Form::select('degree_type', array(
						null => null,
						'Bachelors' => 'Bachelors',
						'Combined Bachelors/Masters' => 'Combined Bachelors/Masters',
						'Masters' => 'Masters',
						'PhD' => 'PhD',
						'N/A' => 'N/A'
					))}}		
				</div>
			</div>
			
			{{-- Graduation Date --}}
			<div class="row">
				{{Form::label('grad_date', 'Expected Graduation Date', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{ Form::select('grad_date', array(
						null => null,
						'May 2014' => 'May 2014',
						'Dec 2014' => 'Dec 2014',
						'May 2015' => 'May 2015',
						'Dec 2015' => 'Dec 2015',
						'May 2016' => 'May 2016',
						'Dec 2016' => 'Dec 2016',
						'May 2017' => 'May 2017',
						'Dec 2017' => 'Dec 2017',
						'May 2018' => 'May 2018',
						'Dec 2018' => 'Dec 2018',
						'May 2019' => 'May 2019',
						'Dec 2019' => 'Dec 2019'
					))}}	
				</div>
			</div>

			{{-- Major --}}
			<div class="row">
				{{Form::label('major[]', 'Major(s)', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{ Form::select('major[]', 
						array(
							'Applied Mathematics and Statistics' => 'Applied Mathematics and Statistics',
							'Chemical Engineering' => 'Chemical Engineering',
							'Chemical & Biochemical Engineering' => 'Chemical & Biochemical Engineering',
							'Chemistry' => 'Chemistry',
							'Civil Engineering' => 'Civil Engineering',
							'Computer Science' => 'Computer Science',
							'Economics' => 'Economics',
							'Electrical Engineering' => 'Electrical Engineering',
							'Engineering' => 'Engineering',
							'Engineering Physics' => 'Engineering Physics',
							'Environmental Engineering' => 'Environmental Engineering',
							'Geological Engineering' => 'Geological Engineering',
							'Geophysical Engineering' => 'Geophysical Engineering',
							'Mechanical Engineering' => 'Mechanical Engineering',
							'Metallurgical & Materials Engineering' => 'Metallurgical & Materials Engineering',
							'Mining Engineering' => 'Mining Engineering',
							'Petroleum Engineering' => 'Petroleum Engineering'
						),null,array(
							'multiple',
							'id' => 'major'
						))
					}}		
				</div>
			</div>
			
			{{-- Minors--}}
			<div class="row">
				{{Form::label('minor', 'Minor(s)', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{ Form::select('minor[]', 
						array(
							'Chemistry' => 'Chemistry',
							'Computational & Applied Mathematics' => 'Computational & Applied Mathematics',
							'Computer Sciences' => 'Computer Sciences',
							'Economics' => 'Economics',
							'Energy' => 'Energy',
							'Engineering (General)' => 'Engineering (General)',
							'Engineering – Civil' => 'Engineering – Civil',
							'Engineering – Electrical' => 'Engineering – Electrical',
							'Engineering – Environmental' => 'Engineering – Environmental',
							'Engineering – Mechanical' => 'Engineering – Mechanical',
							'Engineering Physics' => 'Engineering Physics',
							'Explosive Processing of Materials' => 'Explosive Processing of Materials',
							'Explosives Engineering' => 'Explosives Engineering',
							'Geological Engineering' => 'Geological Engineering',
							'Geophysical Engineering' => 'Geophysical Engineering',
							'Humanitarian Engineering' => 'Humanitarian Engineering',
							'Humanitarian Studies & Technology' => 'Humanitarian Studies & Technology',
							'Humanities' => 'Humanities',
							'International Political Economy' => 'International Political Economy',
							'International Studies' => 'International Studies',
							'Liberal Arts' => 'Liberal Arts',
							'Liberal Arts & International Studies Individualized Undergraduate Minor' => 'Liberal Arts & International Studies Individualized Undergraduate Minor',
							'Literature, Society, & the Environment' => 'Literature, Society, & the Environment',
							'Mathematical & Computer Sciences' => 'Mathematical & Computer Sciences',
							'Mathematical Sciences' => 'Mathematical Sciences',
							'McBride Honors in Public Affairs' => 'McBride Honors in Public Affairs',
							'Metallurgical & Materials Engineering' => 'Metallurgical & Materials Engineering',
							'Military Science' => 'Military Science',
							'Mining Engineering' => 'Mining Engineering',
							'Music Technology' => 'Music Technology',
							'Operations Research' => 'Operations Research',
							'Organic Chemistry' => 'Organic Chemistry',
							'Petroleum Engineering' => 'Petroleum Engineering',
							'Public Affairs' => 'Public Affairs',
							'Science, Technology, & Society' => 'Science, Technology, & Society',
							'Science, Technology, Engineering & Policy' => 'Science, Technology, Engineering & Policy',
							'Statistics' => 'Statistics',
							'Underground Construction & Tunneling' => 'Underground Construction & Tunneling'
						),null,array(
							'multiple',
							'id' => 'minor'
						))
					}}		
				</div>
			</div>
			
			{{-- Classes --}}
			{{--
			<div class="row">
				{{ Form::label('classes', 'Please select the CS classes that you are currently enrolled in:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10')) }}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					<select multiple id="classes-taking" class="select2-container classSelect" name="classes[]">
						<optgroup label="Computer Science">
							@foreach(Course::all() as $course)
								<option value={{ $course->id }}>{{ $course->prefix }}{{ $course->number }} - {{ $course->name }}</option>
							@endforeach
						</optgroup>
					</select>
				</div>
			</div><br>
			--}}
		</div>
		
		{{-- Are you an instructor? --}}
		<div class="row">
			{{Form::label('instructor', 'Are you a CS instructor?', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
			<ul class="list-inline instructor_switch">
				<li> {{ Form::radio('instructor', 'yes', false) }} Yes  </li>
				<li> {{ Form::radio('instructor', 'no', true) }} No </li>
			</ul>
			</div>
		</div>
		
		{{--
		<div id="instructor_panel" style="display: none">
			<div class="row">
				{{ Form::label('classes_instructor', 'Please select the CS classes for which you are currently an instructor:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10')) }}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					<select multiple id="classes-teaching" class="select2-container classSelect" name="classes_instructor[]">
						<optgroup label="Computer Science">
							@foreach(Course::all() as $course)
								<option value={{ $course->id }}>{{ $course->prefix }}{{ $course->number }} - {{ $course->name }}</option>
							@endforeach
						</optgroup>
					</select>
				</div>
			</div><br>
		</div>
		--}}

		{{-- Bio --}}
		<div class="row">
			{{Form::label('bio', 'Say a few things about yourself:', array('class' => 'col-md-offset-2 col-xs-12 col-md-4', 'id' => 'bio-content'))}}	
			<div class ="col-xs-6 col-md-2 col-md-offset-2">
				<a style="float:right" target="_blank" href="http://htmlpurifier.org/"><img src="http://htmlpurifier.org/live/art/powered.png" alt="Powered by HTML Purifier" border="0" /></a>
			</div>
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::textarea('bio', null, array(
				'class' => 'form-control',
				'placeholder' => 'About you. (Goals, likes, dislikes, accomplishments, future plans, etc...) ',
				'rows' => '5'
				))}}
			</div>
		</div>
		@if($errors->has('bio'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2"> 
				{{$errors->first('bio')}}
				</div>
			</div>	
		@endif
		
		{{-- Tags --}}
		<div class="row">
			{{Form::label('hashtags', 'Subscribe to some tags. You will receive an in-app notification when someone makes a post with one of your tags', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
		</div>
		
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				<input type='hidden' style="width:100%;" id="tag-select" class="five-margin" name="hashtags[]"> </input>
			</div>
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				<input type='hidden' disabled style="width:80%;" id="tag-select-suggestions" class="five-margin" name="hashtag_suggestions[]"> </input>
				<button type="button" style="width:20%" id="add-these-tags" class="btn btn-default"> <small>Add Suggested Tags</small> </button>
				<noscript> (This browser does not support JavaScript or JavaScript is turned off. Tagging is disabled) </noscript>
			</div>
		</div>
		
		<br>	
		
		{{-- Email Preferences --}}
		<div class="row">
			{{Form::label('email_pref', 'Email Preferences', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
		</div>
		<div class="row">
			<div class ="col-xs-5 col-md-8 col-md-offset-2">
				<div class="row checkbox-label">
				{{ Form::checkbox('email_conversation', true, true, array('id' => 'conversation_email')) }}
				Receive an email when somebody starts a conversation with you, adds you to a conversation, or replies to a conversation you are in
				</div>
				<div class="row checkbox-label">
				{{ Form::checkbox('email_tag', true, false, array('id' => 'post_email')) }}
				Receive an email when a user posts with a tag you are subscribed to
				</div>
				<div class="row checkbox-label">
				{{ Form::checkbox('email_comment', true, false, array('id' => 'comment_email')) }}
				Receive an email when somebody comments on a post you made	
				</div>
			</div>
		</div>
		
		<br>
		
		{{-- Profile Picture --}}
		<div class="rowlabel">
			{{Form::label('profilepic', 'Profile Picture: (jpeg, png, bmp, or gif && 2MB Maximum size)', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}	
		</div>
		<div class="row">
			<div class ="col-xs-5 col-md-4 col-md-offset-2">
			{{Form::file('profilepic', array('id' => 'picture'))}}		
			</div>
		</div>
		@if($errors->has('profilepic'))
			<div class="row">
				<div class="error col-xs-10 col-md-8 col-md-offset-2">
				{{$errors->first('profilepic')}}
				</div>
			</div>
		@endif
		
		<br>
		
		{{-- Javascript form status--}}
		{{Form::label('status', 'Form Status:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}
		<div class="row">
			<div id="status" class ="col-md-offset-2 col-xs-10 col-md-8">
				<!-- Start empty, filled by js -->
			</div>
		</div>
		
		<br/>
			{{Form::submit('Register', array('class' => 'btn btn-lg btn-success btn-block', 'id' => 'submit-button'))}}
		</div>
		{{ Form::close() }}	
	</div>
</div>
<!-- Loading all scripts at the end for performance-->
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('assets/js/select2.js') }}
<script>
	$(document).ready(function() { 
		$("#grad_date").select2({
			placeholder: "Select Your Expected Graduation Date"
		});
		$("#degree_type").select2({
			placeholder: "Select Your Degree Type"
		});
		$("#major").select2({
			placeholder: "Select Your Major(s)"
		});
		$("#minor").select2({
			placeholder: "Select Your Minors(s)"
		});
		
		$(".instructor_switch").change(function() {
			$("#instructor_panel").slideToggle();
		});
		$(".student_switch").change(function() {
			$("#student_panel").slideToggle();
		});
		
		$("#submit-button").attr('disabled', true);
		verifyFields();
		$("#main").keyup(function() {
			verifyFields();
			//console.log("Value: " + emailUsed);
		});
		$("#male, #female, #pnr").change(function() {
			verifyFields();
		});
		$('#picture').bind('change', function() {
			if(this.files[0].size > 2000000) {
				pictureTooBig = true;
			} else {
				pictureTooBig = false;
			}
			if(this.files[0].type.split('/')[0] == 'image') {
				uploadWrongType = false;
			} else {
				uploadWrongType = true;
			}
			verifyFields();
		});
		$("#email").change(function() {
			isEmailUsed($("#email").val());
		});

		isEmailUsed($("#email").val());
	});
	
	var pictureTooBig = false;
	var uploadWrongType = false;
	var emailUsed = true;
	
	var isEmailUsed = function(email) {
		var toReturn;
		$.ajax({
		url: "{{{URL::to('emailUsed')}}}",
		type: 'POST',
		data: {"email": email},
		dataType: 'json',
		success: function(data){
				//console.log(data.value);
				emailUsed = data.value;
				verifyFields();
			}
		});
	}
	
	var verifyFields = function() {
		var anythingWrong = false;
		var errors = '<div class="alert alert-danger">'
		// All these fields must be filled in
		if($("#first-name").val().length == 0) {
			anythingWrong = true;
			errors = errors + "First Name field must be filled in<br>";
		}
		if($("#last-name").val().length == 0) {
			anythingWrong = true;
			errors = errors + "Last Name field must be filled in<br>";
		}
		if($("#email").val().length == 0) {
			anythingWrong = true;
			errors = errors + "Email field must be filled in<br>";
		}
		if($("#password").val().length == 0) {
			anythingWrong = true;
			errors = errors + "Password field must be filled in<br>";
		}
		if($("#password-confirm").val().length == 0) {
			anythingWrong = true;
			errors = errors + "Password Confirm field must be filled in<br>";
		}
		if($("#picture").val().length == 0) {
			anythingWrong = true;
			errors = errors + "You must upload a profile picture<br>";
		}
		if(!$('#male').is(':checked') && !$('#female').is(':checked') && !$('#pnr').is(':checked')) {
			anythingWrong = true;
			errors = errors + "Gender field must be filled in<br>";	
		}
		
		// Email is valid (Thank you stack overflow for the regular expression)
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var email = $("#email").val();
		if(!re.test(email)) {
			anythingWrong = true;
			errors = errors + "<br>Email must match this regex:<br> /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ <br> Good Luck <br> <br>";
		}
		
		// Email must not be duplicate
		if(emailUsed) {
			anythingWrong = true;
			errors = errors + "This email address has already been used<br>";
		}
		
		// Password Length
		if($("#password").val().length < 4) {
			anythingWrong = true;
			errors = errors + "Password must be more than 3 characters<br>";
		}
		if($("#password").val().length > 32) {
			anythingWrong = true;
			errors = errors + "Password must be smaller than 33 characters<br>";
		}
		
		// Password Match
		if($("#password").val() != $("#password-confirm").val()) {
			anythingWrong = true;
			errors = errors + "Password and Confirm Password fields must match<br>";
		}
		
		// Picture Required
		if(pictureTooBig) {
			anythingWrong = true;
			errors = errors + "The uploaded picture exceeds to 2Mb limit<br>";
		}
		if(uploadWrongType) {
			anythingWrong = true;
			errors = errors + "The uploaded picture is not an image<br>";
		}
		
		if(anythingWrong) {
			errors = errors + "</div>";
			$("#status").html(errors);
			$("#submit-button").attr('disabled', true);
		} else {
			$("#status").html( '<div class="alert alert-success"> All fields complete and verified </div>');
			$("#submit-button").attr('disabled', false);
		}
		
	}
	
	/*
	 * Code for tag suggestions functionality
	 */
	 
	var inputTagData = [
			@foreach(Hashtag::orderBy('name', 'ASC')->get() as $tag)
				{id: {{{$tag->id}}}, text: '{{{ $tag->name }}}'},
			@endforeach
			];
	$(document).ready(function() { 
		// Set up select2 menus for tagging
		$("#tag-select").select2({
			createSearchChoice:function(term, data) { 
				if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {
					if(term.length > 2) {
						return {id:term.replace(/,/g,' '), text:term.replace(/,/g,' ') + " - (This will create a new tag)"};
					}
				}
			},
			multiple: true,
			placeholder: "Please select some tags for this post. Consider adding the tags below.",
			data: inputTagData
		});
		$("#tag-select-suggestions").select2({
			multiple: true,
			placeholder: "Suggested tags will appear here (based on the 'about you' selection).",
			data: inputTagData
		});
	});
	
	// Get hashtag data from db
	var tagData = {
	@foreach(Hashtag::all() as $tag)
		{{{$tag->id}}} : "{{{$tag->name}}}",
	@endforeach
	}
	
	for(var id in tagData) {
		{{-- Convert CamelCase to spaces --}}
		var myStr = tagData[id];
		myStr = myStr.replace(/([a-z])([A-Z])/g, '$1 $2').toLowerCase();
		
		{{-- Convert hyphens and underscores to spaces --}}
		myStr = myStr.replace(/-|_/g, ' ').toLowerCase();
		
		{{-- Convert number letter junctions to spaces --}}
		//myStr = myStr.replace(/([^0-9])([0-9])/g, '$1 $2').toLowerCase();
		
		{{-- Now split the string in to an array (split on whitespace) --}}
		var splitResult = myStr.split(/[ ,]+/);
		tagData[id] = splitResult;
	}

	// Add suggested tags to actual tags on button press
	$('#add-these-tags').click(function() {
		var unionOfSelectMenues = union_arrays($("#tag-select-suggestions").val().split(","),$("#tag-select").val().split(","));
		$("#tag-select").select2('val',unionOfSelectMenues);
	});
	
	// Check for new suggested tags every time content field changes
	$('#bio').keyup(function() {
		delay(function(){
		  updateSuggestedTags();
		}, 1000 );
	});
	
	// This is a delay function, it us used above so that there must be a 1000ms pause in typing before the function executes
	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	  };
	})();
	
	// Also check when a new taking/instructor class is selected
	$('#classes-taking,#classes-teaching').change(function() {
		updateSuggestedTags();
	});
	
	var updateSuggestedTags = function() {
		var newSelectTwoValues = new Array;
		for(var id in tagData) {
			var toSearch = tagData[id];
			for(var word in toSearch) {
				{{-- For security purposes, escape tag text regexp characters. --}}
				var patt = new RegExp(escapeRegExp(toSearch[word]),'i');
				if(patt.test($("#bio").val())) {
					newSelectTwoValues.push(id);
					break;
				}
				{{-- No longer asking for classes
				var classData = $("#classes-taking").select2('data');
				for (var i in classData) {
					//console.log("Comparing " + classData[i].text + " with " + patt);
					if(patt.test(classData[i].text)) {
						newSelectTwoValues.push(id);
						break;
					}
				}
				classData = $("#classes-teaching").select2('data');
				for (var i in classData) {
					//console.log("Comparing " + classData[i].text + " with " + patt);
					if(patt.test(classData[i].text)) {
						newSelectTwoValues.push(id);
						break;
					}
				}
				--}}
			}
		}
		$("#tag-select-suggestions").select2('val',newSelectTwoValues);
	}

	// Helper function to escape regex
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	// Helper function for finding the union of two arrays
	function union_arrays (x, y) {
		var obj = {};
		for (var i = x.length-1; i >= 0; -- i)
			obj[x[i]] = x[i];
		for (var i = y.length-1; i >= 0; -- i)
			obj[y[i]] = y[i];
		var res = []
		for (var k in obj) {
			if (obj.hasOwnProperty(k))  // <-- optional
			res.push(obj[k]);
		}
		return res;
	}

</script>
	
</body>
</html>