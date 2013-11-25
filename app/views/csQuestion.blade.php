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
	<form role="form">
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Name</label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-5 col-md-4">
			<input class="form-control" name="firstname" placeholder="First" type="text" required autofocus />
		</div>
		<div class="col-xs-5 col-md-4">
			<input class="form-control" name="lastname" placeholder="Last" type="text" required />
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>E-mail</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="email" placeholder="E-mail" type="text" required />
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Degree Type</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="degree" placeholder="Bachelors" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Graduation Date</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="graddate" placeholder="May 2015" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Major(s)</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="major" placeholder="Computer Science" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-5 col-md-4">
			<label>Minor(s)</label>
		</div>
	</div>
	<div class="row">
		<div class ="col-xs-10 col-md-8">
			<input class="form-control" name="minor" placeholder="BELS, Physics" type="text"/>
		</div>
	</div>
	
	<div class="row">
		<div class ="col-xs-12 col-md-12">
			<label>Please check classes that you are currently enrolled in:</label>
		</div>
	</div>
	
	<div class="scroll">
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci101"> CSCI-101 (Intro to Computer Science)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci261"> CSCI-261 (Programming Concepts)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci262"> CSCI-262 (Data Structures)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci274"> CSCI-274 (Introduction to the Linux Operating System)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci306"> CSCI-306 (Software Engineering)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci341"> CSCI-341 (Computer Organization)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci400"> CSCI-400 (Principles of Programming Languages)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci403"> CSCI-403 (Database Management)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci404"> CSCI-404 (Artificial Intelligence)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci406"> CSCI-406 (Algorithms)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci410"> CSCI-410 (Elements of Computing Systems)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci442"> CSCI-442 (Operating Systems)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci445"> CSCI-445 (Web Programming)
			</label>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" value="csci446"> CSCI-446 (Web Applications)
			</label>
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