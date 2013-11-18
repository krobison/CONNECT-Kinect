<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/csNewUser.css') }}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	{{ HTML::script('assets/js/ajaxtext.js') }}

</head>

<body>
	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-jlyons/img/Connect_Logo.png">
	</div>
		
	<div class="container">
	
	{{ Form::open(array('url' => 'newuser')) }}

	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Post Type</label>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="type" placeholder="Help" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Number of Upvotes</label>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="upvotes" placeholder="4" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-12 col-md-12">
			<label>Select the Poster:</label>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-12 col-md-12">
			{{ Form::select('user_id', User::lists('id')) }}
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-10">
			<label>Enter the Post Content:</label>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<textarea name="content" class="form-control" rows="5" placeholder="Last"> </textarea>
		</div>
	</div>
	
	<br />
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>		
		</div>
	</div>
	
	{{ Form::close() }}
	
</div>
	
</body>
</html>