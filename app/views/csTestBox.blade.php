<!DOCTYPE html>
<html>

<head>
{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('app/views/css/csNewUser.css') }}
</head>

<body>

{{ HTML::style('css/select2.css') }}
{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
{{ HTML::script('js/select2.js') }}


	<div class="page-header">
		<img class="logo" src="http://toilers.mines.edu/csconnect-jlyons/img/Connect_Logo.png">
	</div>
	<h2>Old:</h2>
		
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
</div>

<h2>New:</h2>
	
	
	<script>
        $(document).ready(function() { 
			$("#classSelect").select2({
			placeholder: "Select Your Classes"
			});
		});
    </script>

		<select multiple class="select2-container classSelect" id="classSelect">
			<optgroup label="Computer Science">
				<option>CSCI 101 - Intro to Computer Science</option>
				<option>CSCI 261 - Programming Concepts</option>
				<option>CSCI 262 - Data Structures</option>
			</optgroup>
		</select>
</body>
</html>