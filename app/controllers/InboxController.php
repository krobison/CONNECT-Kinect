<?php

class InboxController extends BaseController {	

	// in the end this will show all unique convesations
	// I don't know if unique conversations should be queryied through
	// 		controller or the model. Or how the database should be set
	// 		up to keep track of conversations
	public function showInbox() {
		//right now only displays construction page
		//dd(Message::all());

		// $message = Message::find(1);
		// dd($message->toUser);

		$user = Auth::user();
	
		$sentMessages = Message::where('from', '=', $user->id)->get();
		$receivedMessages = Message::where('to', '=', $user->id)->get();


		return View::make('inbox')
			->with('user', Auth::user())
			->with('sentMessages', $sentMessages)
			->with('receivedMessages', $receivedMessages);
	}

	// Show the user individual conversation
	public function showConversation()
	{
		return View::make('conversation')
			->with('user', Auth::user());
	}

	public function messageUser($userId)
	{
		return View::make('messageTo')
			->with('user', Auth::user())
			->with('toUser', User::find($userId));
	}

	public function createMessage()
	{
		// dd(Input::get('content'));
		try {
			$message = new Message;

			$message->to = Input::get('to');
			$message->from = Input::get('from');
			$message->content = Input::get('content');
			$message->subject = Input::get('subject');

			$message->save();
			return Redirect::back()->with('message', "You have messaged successfully");
		} catch( Exception $e ) {

			dd($e);

			return Redirect::back()->with('message', "You have messaged unsuccessfully");
		}
	}
}