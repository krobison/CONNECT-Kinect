<head>
	<!-- Loading CSS-->
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	<style>
		html, body{
			background: url("../assets/img/background.png") no-repeat center center fixed;
		}
		#form-container {
			margin: 100px;
			width: 340px;
		}
		.btn {
			width: 300px;
		}
		#text {
			width: 255px;
		}
	</style>
</head>

<body>
	@if (Session::has('error'))
		<div class="alert alert-danger"> {{{ trans(Session::get('reason')) }}} </div>
	@elseif (Session::has('success'))
		<div class="alert alert-success"> An email with the password reset has been sent. </div>
	@endif
	 
	<div id="form-container" class="well">
		<h3> <u>Password Recovery</u> </h3>
		<br>
		
		{{ Form::open(array('route' => 'password.request')) }}
		
		<p>{{ Form::label('email', 'Email: ') }}
		{{ Form::text('email', '', array('placeholder'=> 'Email','id' => 'text')) }}</p>
		
		<br>
		
		<p>{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}</p>
		
		{{ Form::close() }}
	</div>
</body>