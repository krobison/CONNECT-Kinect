<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<div>
		
		{{{$reciever->first}}},
		
		<br>
		<br>
		
		{{{Auth::user()->first}}} {{{Auth::user()->last}}} commented on a post that you wrote. Follow this link to see the comment {{ URL::to('singlepost/'.$post) }}.

		<br>
		<br>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>