function verify(is_host) {
	if (is_host)
	{
		var agree = confirm("Finalizing will send an email to all group members. Be sure to select a restaurant and enter details for where to meet. OK to send message?");
		if (agree)
			return true;
		else
			return false;
	}
	else {
		return true;
	}
}

function allowDelete(is_host) {
	if (is_host)
	{
		var agree = confirm("Deleting will send an email to all group members. OK to send message?");
		if (agree)
			return true;
		else
			return false;
	}
	else {
		return true;
	}
}
