<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/csNewUser.css') }}
	{{ HTML::style('css/select2.css') }}
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
	{{ HTML::script('js/select2.js') }}
</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-jlyons/img/Connect_Logo.png">
	</div>	
	
	@if(Session::has('message'))		
		<p> There has been a problem registering your information please try again later. </p>
	@endif
	
	
	<div class="container">
	{{Form::open(array('route' => 'csSignUp', 'files' => true))}}
	<div class="row">
		{{Form::label('name', 'Name', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}
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

	<div class="row">
		{{Form::label('email', 'E-mail', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}
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

	<div class="row">
		{{Form::label('password', 'Password', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}
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
	<div class="row">
		{{Form::label('password_confirmation', 'Password Confirm', array('class' => 'col-md-offset-2 col-xs-5 col-md-4'))}}	
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
	
	<?php 
		$classes = array(
		1 => 'CSCI-101 (Intro to Computer Science)',
		2 => 'CSCI-261 (Programming Concepts)',
		3 => 'CSCI-262 (Data Structures)',
		4 => 'CSCI-274 (Introduction to the Linux Operating System)',
		5 => 'CSCI-306 (Software Engineering)',
		6 => 'CSCI-341 (Computer Organization)',
		7 => 'CSCI-400 (Principles of Programming Languages)'
	);
	?>
	<div class="row">
		{{Form::label('classes', 'Please select classes that you are currently enrolled in:', array('class' => 'col-md-offset-2 col-xs-12 col-md-10'))}}	
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-8 col-md-offset-2">
			{{Form::select('classes[]', $classes, null, array(
				'class' => 'form-control',
				'size' => '5',
				'multiple'
				
			))}}		
		</div>
	</div>
	
	<!--
	<div class="scroll">
		<div class="checkbox">
			<input class="checkbox" type="checkbox" value="csci101"> CSCI-101 (Intro to Computer Science)
		</div>
		<div class="checkbox">
			<input type="checkbox" value="csci261"> CSCI-261 (Programming Concepts)
		</div>
		<div class="checkbox">
			<input type="checkbox" value="csci262"> CSCI-262 (Data Structures)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci274"> CSCI-274 (Introduction to the Linux Operating System)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci306"> CSCI-306 (Software Engineering)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci341"> CSCI-341 (Computer Organization)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci400"> CSCI-400 (Principles of Programming Languages)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci403"> CSCI-403 (Database Management)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci404"> CSCI-404 (Artificial Intelligence)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci406"> CSCI-406 (Algorithms)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci410"> CSCI-410 (Elements of Computing Systems)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci442"> CSCI-442 (Operating Systems)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci445"> CSCI-445 (Web Programming)
		</div>
		
		<div class="checkbox">
			<input type="checkbox" value="csci446"> CSCI-446 (Web Applications)
		</div>
		
	</div>
	-->
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
			{{Form::submit('Register', array('class' => 'btn btn-lg btn-primary btn-block'))}}			</div>
		</div>
	{{ Form::close() }}	
</div>
	
	
</body>
</html>