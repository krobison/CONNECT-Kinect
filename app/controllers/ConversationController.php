<?php

include(app_path().'/purify/HTMLPurifier.auto.php');
include('helpers/lib_autolink.php');

class ConversationController extends BaseController {
	
	public function showConversations() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "conversations accessed";
		$log->save();

		return View::make('conversations')
			->with('user', Auth::user())
			->with('conversations', Auth::user()->conversations);
	}
	
	public function composeConversation() {
		return View::make('composeConversation')
			->with('user', Auth::user())
			->with('toUser','none');
	}

	public function messageUser($id){
		return View::make('composeConversation')
			->with('user', Auth::user())
			->with('toUser',$id);
	}
	
	public function showConversation($id) {
		//ensure that you can only view conversations that 1)Exist, and 2)You are a part of
		$result = DB::table('conversation_user')
			->where('user_id','=',Auth::user()->id)
			->where('conversation_id','=',$id)
			->get();

		if (empty($result)){
			return Redirect::to('newsfeed')->with('message', '<div class="alert alert-danger"> The conversation you requested has been deleted or you are not a member of this conversation. </div>');
		} else {
			return View::make('singleConversation')
			->with('user', Auth::user())
			->with('conversation', Conversation::find($id));
		}
	}

	public function leaveConversation($id) {

		$result = DB::table('conversation_user')
			->where('user_id','!=',Auth::user()->id)
			->where('conversation_id','=',$id)
			->get();

		if (empty($result)){
			DB::table('conversation_user')
				->where('user_id','=',Auth::user()->id)
				->where('conversation_id','=',$id)
				->delete();
			DB::table('conversations')
				->where('id','=',$id)
				->delete();
			DB::table('notes')
				->where('conversation_id','=',$id)
				->delete();
		}else{
			DB::table('conversation_user')
				->where('user_id','=',Auth::user()->id)
				->where('conversation_id','=',$id)
				->delete();
		}

		return Redirect::to('conversations');
	}

	public function removeUser($userId,$conversationId) {

		$conversation = DB::table('conversations')->where('id','=',$conversationId)->first();

		if($conversation->owner == Auth::user()->id){

			DB::table('conversation_user')
				->where('user_id','=',$userId)
				->where('conversation_id','=',$conversationId)
				->delete();

		}


		return Redirect::to('showConversation/'.$conversationId);
	}

	public function addUsers($conversationId){
		$conversation = Conversation::find($conversationId);
		if (Auth::user()->id == $conversation->owner){
			$usersToAddRaw = Input::get('users');
			$usersToAdd = array_map('intval', $usersToAddRaw);
			$conversation->users()->attach($usersToAdd);
		}

		$this->addConversationAddNotifications($usersToAdd,$conversationId);

		return Redirect::to('showConversation/'.$conversationId);
	}

	public function addConversationCreatedNotifications($users,$cId){
		foreach ($users as $user) {
			$user = User::find($user);
			if ($user->id != Auth::user()->id){
				$not = new Notification;
				$not->user_id = $user->id;
				$not->initiator_id = Auth::user()->id;
				$not->type = 'conversationCreated';
				$not->origin_id = $cId;
				$not->save();
				
				// If the user has opted to receive emails for conversation notifications 
				if($user->email_conversation == true) {
					Mail::send('emails.conversationCreated_notification', array("reciever" => $user, "conversation" => $cId) , function($message) use ($user){
						$message->to($user->email, $user->first . " " . $user->last)->subject('CS CONNECT -- Conversation Notification');
					});
				}
			}
		}
	}

	public function addConversationReplyNotifications($users,$cId){
		foreach ($users as $user) {
			if ($user->id != Auth::user()->id){
				$not = new Notification;
				$not->user_id = $user->id;
				$not->initiator_id = Auth::user()->id;
				$not->type = 'conversationReply';
				$not->origin_id = $cId;
				$not->save();
				
				// If the user has opted to receive emails for conversation notifications 
				if($user->email_conversation == true) {
					Mail::send('emails.conversationReply_notification', array("reciever" => $user, "conversation" => $cId) , function($message) use ($user){
						$message->to($user->email, $user->first . " " . $user->last)->subject('CS CONNECT -- Conversation Notification');
					});
				}
			}
		}
	}

	public function addConversationAddNotifications($users,$cId){
		foreach ($users as $user) {
			$user = User::find($user);
			if ($user->id != Auth::user()->id){
				$not = new Notification;
				$not->user_id = $user->id;
				$not->initiator_id = Auth::user()->id;
				$not->type = 'conversationAdd';
				$not->origin_id = $cId;
				$not->save();
			
				// If the user has opted to receive emails for conversation notifications 
				if($user->email_conversation == true) {
					Mail::send('emails.conversationAdd_notification', array("reciever" => $user, "conversation" => $cId) , function($message) use ($user){
						$message->to($user->email, $user->first . " " . $user->last)->subject('CS CONNECT -- Conversation Notification');
					});
				}
			}
		}
	}
	
	public function createConversation() {
		
		// convert the stupid array, gosh darn it!
		$stringIDs = Input::get('users');
		// make sure I'm part of the convo too!
		array_push($stringIDs, Auth::user()->id);
		// then convert to ints
		$integerIDs = array_map('intval', $stringIDs);
		
		// create conversation
		$conversation = new Conversation;
		$conversation->name = Input::get('name');
		$conversation->owner = Input::get('from');
		
		$conversation->save();
		
		// then sync the array of people
		$conversation->users()->sync($integerIDs);

		$this->addConversationCreatedNotifications($integerIDs,$conversation->id);
		
		// creating note
		$note = new Note;
		
		//PURIFY
		$pureconfig = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($pureconfig);
		$content = $purifier->purify(Input::get('content'));

		$note->content = autolink($content); // Linkify 
		$note->user_id = Auth::user()->id;
		
		//$note->save();
		
		// attach note to conversation
		$note->conversation_id = $conversation->id;
		
		$note->save();	
		
		return Redirect::to('conversations');
		
	}
	
	public function addToConversation() {
		//PURIFY
		$pureconfig = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($pureconfig);
		$content = $purifier->purify(Input::get('content'));

		$conversation = Conversation::find(Input::get('conversationID'));

		if (!empty($content)){		
			$this->addConversationReplyNotifications($conversation->users,$conversation->id);

			$note = new Note;
			
			$note->content = autolink($content);
			$note->user_id = Auth::user()->id;
			
			// attach note to conversation
			$note->conversation_id = $conversation->id;
			
			$note->save();
		}
		
		return Redirect::to('showConversation/'.$conversation->id);

		
	}
	
}

