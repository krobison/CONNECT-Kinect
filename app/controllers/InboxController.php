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

		if ($to->id == Auth::user()->id){
			return View::make('messageDetail')
				->with('user', Auth::user())
				->with('messages', $messages)
				->with('message',$message)
				->with('from',$from);
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

	public function createMessage()
	{
		// dd(Input::get('content'));
		try {
			$message = new Message;

			$message->to = Input::get('to');
			$message->from = Input::get('from');
			$message->content = Input::get('content');
			$message->subject = Input::get('subject');
			$message->viewed = "0";

			$message->save();
			return Redirect::back()->with('message', "You have messaged successfully");
		} catch( Exception $e ) {

			dd($e);

			return Redirect::back()->with('message', "You have messaged unsuccessfully");
		}
	}
}