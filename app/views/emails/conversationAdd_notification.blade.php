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
		
		{{{Auth::user()->first}}} {{{Auth::user()->last}}} has added you to a conversation. Follow this link to see the conversation {{ URL::to('showConversation/'.$conversation) }}.

		<br>
		<br>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>