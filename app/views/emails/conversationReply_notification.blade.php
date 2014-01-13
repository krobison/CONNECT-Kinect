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
		
		{{{Auth::user()->first}}} {{{Auth::user()->last}}} has replied in a conversation you are in. Follow this link to see the reply {{ URL::to('showConversation/'.$conversation) }}.

		<br>
		<br>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>