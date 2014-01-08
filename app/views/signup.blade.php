<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/csNewUser.css') }}
	{{ HTML::style('assets/css/select2.css') }}
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
		<div class="row">
			<div class="col-xs-5 col-md-4 col-md-offset-2">
				{{Form::text('first', null, array(
					'id' => 'first-name',
					'class' => 'form-control',
					'placeholder' => 'First',
					'autofocus',
					'required'
				))}}
			</div>
			<div class="col-xs-5 col-md-4">
				{{Form::text('last', null, array(
					'id' => 'last-name',
					'class' => 'form-control',
					'placeholder' => 'Last',
					'required'
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

		<div class="rowlabel">
			{{Form::label('email', 'E-mail', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::text('email', null, array(
					'id' => 'email',
					'class' => 'form-control',
					'placeholder' => 'E-mail',
					'required'
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

		<div class="rowlabel">
			{{Form::label('password', 'Password', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}
		</div>
		<div class="row">
			<div class ="col-xs-10 col-md-8 col-md-offset-2">
				{{Form::password('password', array(
					'id' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Password',
					'required'
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
					'required'
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
			<div class="row">
				{{Form::label('degree_type', 'Degree Type', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{Form::text('degree_type', null, array(
						'class' => 'form-control',
						'placeholder' => 'Bachelors'
					))}}		
				</div>
			</div>
			
			<div class="row">
				{{Form::label('grad_date', 'Graduation Date', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{Form::text('grad_date', null, array(
						'class' => 'form-control',
						'placeholder' => 'May 2015'
					))}}
				</div>
			</div>

			<div class="row">
				{{Form::label('major', 'Major(s)', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{Form::text('major', null, array(
						'class' => 'form-control',
						'placeholder' => 'Computer Science'
					))}}		
				</div>
			</div>
			
			<div class="row">
				{{Form::label('minor', 'Minor(s)', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
			</div>
			<div class="row">
				<div class ="col-xs-10 col-md-8 col-md-offset-2">
					{{Form::text('minor', null, array(
						'class' => 'form-control',
						'placeholder' => 'BELS, Physics'
					))}}		
				</div>
			</div>
			
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
		</div>
		
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
				'placeholder' => 'About you...',
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
		
		<div class="row">
			{{Form::label('hashtags', 'Add some tags to your profile that correspond to your interest areas, new tags welcome', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
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
			
		<div class="row">
			{{Form::label('profilepic', 'Profile Picture: (jpeg, png, bmp, or gif && 2MB Maximum size)', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
		</div>
		<div class="row">
			<div class ="col-xs-5 col-md-4 col-md-offset-2">
			{{Form::file('profilepic', array())}}		
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
		
		{{Form::label('status', 'Form Status:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}
		<div class="row">
			<div id="status" class ="col-md-offset-2 col-xs-10 col-md-8">
			
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
		$(".select2-container").select2({
			placeholder: "Select Your Classes"
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
		});
	});
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
		
		// Email is valid (Thank you stack overflow for the regular expression)
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var email = $("#email").val();
		if(!re.test(email)) {
			anythingWrong = true;
			errors = errors + "<br>Email must match this regex:<br> /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ <br> Good Luck <br> <br>";
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
			placeholder: "Suggested tags will appear here (based on 'about you' and class selections).",
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
		updateSuggestedTags();
	});
	
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
				var classData = $("#classes-taking").select2('data');
				for (var i in classData) {
					console.log("Comparing " + classData[i].text + " with " + patt);
					if(patt.test(classData[i].text)) {
						newSelectTwoValues.push(id);
						break;
					}
				}
				classData = $("#classes-teaching").select2('data');
				for (var i in classData) {
					console.log("Comparing " + classData[i].text + " with " + patt);
					if(patt.test(classData[i].text)) {
						newSelectTwoValues.push(id);
						break;
					}
				}
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