<?php

class InboxController extends BaseController {	

	// in the end this will show all unique conversations
	// I don't know if unique conversations should be queryied through
	// 		controller or the model. Or how the database should be set
	// 		up to keep track of conversations
	public function showInbox() {
		//right now only displays construction page
		//dd(Message::all());

		// $message = Message::find(1);
		// dd($message->toUser);
	
		$messages = Message::
			Where('to', '=', Auth::user()->id)
			->where('viewed','=','0')
			->get();
		$users = User::select('id', 'first', 'last')->get();

		$conv_users[] = "";
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
			->with('showMessages', $messages)
			->with('users', $conv_users);
	}

	public function messageCompose()
	{

		return View::make('messageCompose')
			->with('user', Auth::user())
			->with('toUser', "none");
	}

	// Show the user individual conversation
	public function showConversation()
	{
		return View::make('conversation')
			->with('user', Auth::user());
	}

	public function messageUser($userId)
	{
		return View::make('messageCompose')
			->with('user', Auth::user())
			->with('toUser', User::find($userId));
	}

	public function showMessage($id){
		$messages = Message::
			Where('to', '=', Auth::user()->id)
			->where('viewed','=','0')
			->get();

		DB::table('messages')
            ->where('id', $id)
            ->update(array('viewed' => 1));

		$message = Message::where('id', '=', $id)->first();
		if (empty($message)){
			return Redirect::to('/');
		}

		$from = User::where('id','=',$message->from)->first();
		$to = User::where('id','=',$message->to)->first();

		if ( ($to->id == Auth::user()->id) || ($from->id == Auth::user()->id) ){
			return View::make('messageDetail')
				->with('user', Auth::user())
				->with('messages', $messages)
				->with('message',$message)
				->with('from',$from)
				->with('to',$to);
		}else{
			return Redirect::to('/');
		}
	}

	public function showOldMail(){
			$messages = Message::
			Where('to', '=', Auth::user()->id)
			->where('viewed','=','0')
			->get();

			$oldmessages = Message::
			Where('to', '=', Auth::user()->id)
			->where('viewed','=','1')
			->get();

		$users = User::select('id', 'first', 'last')->get();

		$conv_users[] = "";
		foreach ($oldmessages as $message) {
			foreach ($users as $user) {
				if($user['id'] == $message['to'] || $user['id'] == $message['from']) {
					$conv_users[$user['id']] = $user['first'] . " " . $user['last'];
				}
			}
		}
		return View::make('inbox')
			->with('user', Auth::user())
			->with('messages', $messages)
			->with('showMessages',$oldmessages)
			->with('users', $conv_users);
	}

	public function showSentMail(){
		$messages = Message::
		Where('to', '=', Auth::user()->id)
		->where('viewed','=','0')
		->get();

		$sentmessages = Message::
		Where('from', '=', Auth::user()->id)
		->get();

		$users = User::select('id', 'first', 'last')->get();

		$conv_users[] = "";
		foreach ($sentmessages as $message) {
			foreach ($users as $user) {
				if($user['id'] == $message['to'] || $user['id'] == $message['from']) {
					$conv_users[$user['id']] = $user['first'] . " " . $user['last'];
				}
			}
		}
		return View::make('inbox')
			->with('user', Auth::user())
			->with('messages', $messages)
			->with('showMessages',$sentmessages)
			->with('users', $conv_users);
	}

	// Doesn't use models the correct way. Brute forces all the database table entries.
	// Later this should use model relationships and should allow for more readable code
	public function createMessage()
	{
		// dd(Input::get('content'));
		try {
			//save message to the message database table
			$message = new Message;
			$message->from = Input::get('from');
			$message->content = Input::get('content');
			$message->subject = Input::get('subject');
			$message->viewed = "0";
			$message->save();

			// save all the recipients for the message
			// check for multiple recipients
			// common practice should be to use messageCompose to send any message. This will then only output an array of recipient users
			if(gettype(Input::get('to'))."" == "array") {
				$recipients = Input::get('to');
				foreach ($recipients as $recipient) {
					$user_message = new User_message;
					$user_message->user_id = $recipient;
					$user_message->message_id = $message->id;
					$user_message->save();

					// uncomment when conversations are more thought out
					//  ideas are welcome
					// $user_message->converstion_id
				}
				dd("it completed!");
			} else {
				$message->to = Input::get('to');
			}
			return Redirect::back()->with('message', "You have messaged successfully");

		} catch( Exception $e ) {

			dd($e);

			return Redirect::back()->with('message', "You have messaged unsuccessfully");
		}
	}
}