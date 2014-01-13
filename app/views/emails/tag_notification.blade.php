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
		
		{{{Auth::user()->first}}} {{{Auth::user()->last}}} has created a post with a tag that you are subscribed to. Follow this link to see the post {{ URL::to('singlepost/'.$post) }}.

		<br>
		<br>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>