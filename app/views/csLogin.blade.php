<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}

</head>

<body>
	
	<div class="container">
		<p>csLogin Page</p>
	
		<form>
			<fieldset>
				<legend>Legend</legend>
				<label>Label name</label>
				<input type="text" placeholder="Type something">
				<span class="help-block">Example block-level help text here.</span>
				<label class="checkbox">
					<input type="checkbox"> Check me out
				</label>
				<button type="submit" class="btn">Submit</button>
			</fieldset>
		</form>

	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>