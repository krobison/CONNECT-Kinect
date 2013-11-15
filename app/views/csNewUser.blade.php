<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/csNewUser.css') }}

</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-jlyons/img/Connect_Logo.png">
	</div>
		
	<div class="container">
		{{Form::open(array('route' => 'csSignUp'))}}
	<div class="row">
		{{Form::label('name', 'Name', array('class' => 'col-xs-5 col-md-4'))}}
	</div>
	<div class="row">
		<div class="col-xs-5 col-md-4">
			{{Form::text('firstname', null, array(
				'class' => 'form-control',
				'placeholder' => 'First',
				'autofocus' => 'autofocus',
				'required' => 'required'
			))}}
		</div>
		<div class="col-xs-5 col-md-4">
			{{Form::text('lastname', null, array(
				'class' => 'form-control',
				'placeholder' => 'Last',
				'required' => 'required'
			))}}		
		</div>
	</div>
	

	<div class="row">
		{{Form::label('email', 'E-mail', array('class' => 'col-xs-5 col-md-4'))}}
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('email', null, array(
				'class' => 'form-control',
				'placeholder' => 'E-mail',
				'required' => 'required'
			))}}		
		</div>
	</div>

	<div class="row">
		{{Form::label('password', 'Password', array('class' => 'col-xs-5 col-md-4'))}}
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('password', null, array(
				'class' => 'form-control',
				'placeholder' => 'Password',
				'required' => 'required'
			))}}		
		</div>
	</div>

	<div class="row">
		{{Form::label('passwordconfirm', 'Password Confirm', array('class' => 'col-xs-5 col-md-4'))}}	
	</div>

	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('passwordconfirm', null, array(
				'class' => 'form-control',
				'placeholder' => 'Password Confirm',
				'required' => 'required'
			))}}		
		</div>
	</div>

	<div class="row">
			{{Form::label('degree', 'Degree Type', array('class' => 'col-xs-5 col-md-4'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('degree', null, array(
				'class' => 'form-control',
				'placeholder' => 'Bachelors'
			))}}		
		</div>
	</div>
	
	<div class="row">
			{{Form::label('graddate', 'Graduation Date', array('class' => 'col-xs-5 col-md-4'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
		{{Form::text('graddate', null, array(
				'class' => 'form-control',
				'placeholder' => 'May 2015'
			))}}
		</div>
	</div>

	<div class="row">
		{{Form::label('major', 'Major(s)', array('class' => 'col-xs-5 col-md-4'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('major', null, array(
				'class' => 'form-control',
				'placeholder' => 'Computer Science'
			))}}		
		</div>
	</div>
	
	<div class="row">
		{{Form::label('minor', 'Minor(s)', array('class' => 'col-xs-5 col-md-4'))}}	
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			{{Form::text('minor', null, array(
				'class' => 'form-control',
				'placeholder' => 'BELS, Physics'
			))}}		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-12 col-md-12">
			<label>Please check classes that you are currently enrolled in:</label>
		</div>
	</div>
	
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
	
	<div class="row">
		<div class ="col-xs-10 col-md-10">
			<label>Say a few things about yourself:</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<textarea name="description" class="form-control" rows="5">About you...</textarea>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-10">
			<label>Profile Picture:</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-5 col-md-4">
				 <input type="file" id="profilepic" name="profilepic">		
		</div>
	</div>
	<br />
	<div class="row">
		<div class ="col-xs-5 col-md-4">
				<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>		
		</div>
	</div>
	</form>
	
</div>
	
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>