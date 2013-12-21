<?php

class InboxController extends BaseController {	

	// in the end this will show all unique convesations
	// I don't know if unique conversations should be queryied through
	// 		controller or the model. Or how the database should be set
	// 		up to keep track of conversations
	public function showInbox() {
		//right now only displays construction page
		return View::make('inbox')
			->with('user', Auth::user());
	}


	// Show the user individual conversation
	public function showConversation()
	{
		return View::make('conversation')
			->with('user', Auth::user());
	}
}