<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/csLogin.css') }}

</head>

<body>
	
	<div class="container">

		<form role="form" class="login-form">
		  <div class="form-group">
			<label for="exampleInputEmail1">Username</label>
			<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" required>
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
		  </div>
		  <div class="checkbox">
			<label>
			  <input type="checkbox"> Remember me
			</label>
		  </div>
		  <button type="submit" class="btn btn-default">Log in</button>
		</form>

    </div>
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>