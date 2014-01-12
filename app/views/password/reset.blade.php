<!DOCTYPE html>
<html>

<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	<style>
		html, body{
			background: url("../../assets/img/background.png") no-repeat center center fixed;
		}
		#form-container {
			margin: 100px;
			width: 410px;
		}
		.btn {
			width: 370px;
		}
		.text {
			width: 230px;
			float: right;
		}
	</style>
</head>

@if (Session::has('error'))
  <div class="alert alert-danger"> {{ trans(Session::get('reason')) }} </div>
@endif
<div id="form-container" class="well">
<h3> <u>Password Reset <ul></h3>
<br>
{{ Form::open(array('route' => array('password.update', $token))) }}
 
	<p>{{ Form::label('email', 'Email: ') }}
	{{ Form::text('email',"", array('placeholder'=> 'Email', 'class' => 'text')) }}</p>

	<p>{{ Form::label('password', 'Password: ') }}
	{{ Form::password('password', array('placeholder'=> 'Password', 'class' => 'text')) }}</p>

	<p>{{ Form::label('password_confirmation', 'Password Confirm: ') }}
	{{ Form::password('password_confirmation', array('placeholder'=> 'Password Confirm', 'class' => 'text')) }}</p>

	{{ Form::hidden('token', $token) }}
	<br>

	<p>{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}</p>
 
{{ Form::close() }}
</div>

</html>