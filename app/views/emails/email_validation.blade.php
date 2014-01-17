<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<div>
		
		{{{$receiver->first}}},
		
		<br/>
		<br/>
		
		Click on the following link to have your email validated so you may begin using the CS CONNECT system:<br/>
		<br/>
		<a href="{{ URL::to('validate', array('key' => $key)) }}">{{ URL::to('validate') }}</a>

		<br/>
		<br/>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>