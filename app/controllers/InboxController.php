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
	
		// Get unread messages
		$messages = Message::
		Where('to', '=', Auth::user()->id)
		->where('viewed','=','0')
		->get();
	
		// Mark the message as read
		DB::table('messages')
            ->where('id', $id)
            ->update(array('viewed' => 1));

		// Get the message database object
		$message = Message::where('id', '=', $id)->first();
		if (empty($message)){
			return Redirect::to('/');
		}

		//if ( ($to->id == Auth::user()->id) || ($from->id == Auth::user()->id) ){
			return View::make('messageDetail')
				->with('user', Auth::user())
				->with('messages', $messages)
				->with('message',$message);
		//} else{
		//	return Redirect::to('/');
		//}
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

	// Send the message
	public function createMessage()
	{
		//try {
			// Save the message to the message database table
			$message = new Message;
			$message->from = Auth::user()->id;
			$message->content = Input::get('content');
			$message->subject = Input::get('subject');
			$message->viewed = "0";
			$message->save();
			
			// Add an entry in user_message table for each recipient
			$recipients = Input::get("to");
			foreach($recipients as $recipient) {
				User::find($recipient)->recieved_messages()->attach($message); 
			}

			return Redirect::back()->with('message', '<div class="alert alert-success"> Your message has been sent successfully. </div>');
		//} catch( Exception $e ) {
		//	return Redirect::back()->with('message', '<div class="alert alert-danger"> Message failed to send </div>');
		//}
	}
}