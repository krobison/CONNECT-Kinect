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
	
		$messages = Message::where('from', '=', Auth::user()->id)
			->orWhere('to', '=', Auth::user()->id)
			->get();
		$users = User::select('id', 'first', 'last')->get();

		foreach ($messages as $message) {
			foreach ($users as $user) {
				if($user['id'] == $message['to'] || $user['id'] == $message['from']) {
					$conv_users[$user['id']] = $user['first'] . " " . $user['last'];
				}
			}
		}
		return View::make('inbox')
			->with('user', Auth::user())
			->with('messages', $messages)
			->with('users', $conv_users);
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