<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/csNewUser.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
	{{ HTML::script('assets/js/select2.js') }}
	
</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-jlyons/img/Connect_Logo.png">
	</div>	
	
	@if(Session::has('message'))		
		<p> There has been a problem registering your information please try again later. </p>
	@endif
	
	
	<div class="container">
	{{ Form::open(array('url' => 'signup', 'files' => true)) }}
	<div class="rowlabel">
		{{Form::label('name', 'Name', array('class' => 'col-md-offset-2')).'<span class="requiredtext"> *Required</span>'}}  
	</div>
	<div class="row">
		<div class="col-xs-5 col-md-4 col-md-offset-2">
			{{Form::text('first', null, array(
				'class' => 'form-control',
				'placeholder' => 'First',
				'autofocus',
				'required'
			))}}
		</div>
		<div class="col-xs-5 col-md-4">
			{{Form::text('last', null, array(
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
		{{Form::label('classes', 'Please select classes that you are currently enrolled in:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8 col-md-offset-2">
			<select multiple class="select2-container classSelect" id="classSelect">
				<optgroup label="Computer Science">
					<option>CSCI 101 - Introduction to Computer Science</option>
					<option>CSCI 261 - Programming Concepts</option>
					<option>CSCI 262 - Data Structures</option>
				</optgroup>
			</select>
		</div>
	</div><br>
	<script>
        $(document).ready(function() { 
			$("#classSelect").select2({
			placeholder: "Select Your Classes"
			});
		});
    </script>
	
	<div class="row">
		{{Form::label('bio', 'Say a few things about yourself:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
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
		{{Form::label('profilepic', 'Profile Picture:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-5 col-md-4 col-md-offset-2">
		{{Form::file('profilepic', array())}}		
		</div>
	</div>
	
	<br />
	<div class="row">
		<div class ="col-xs-5 col-md-4 col-md-offset-2">
			{{Form::submit('Register', array('class' => 'btn btn-lg btn-primary btn-block'))}}
		</div>
	</div>
	{{ Form::close() }}	
</div>
	
	
</body>
</html>