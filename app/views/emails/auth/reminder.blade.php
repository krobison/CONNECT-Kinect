<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
		
		You are receiving this email because we received a password reset request through the CS CONNECT System.

		<br>
		<br>
		
		To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.

		<br>
		<br>
		
		-- The CONNECT Team
		
		</div>
		
	</body>
</html>