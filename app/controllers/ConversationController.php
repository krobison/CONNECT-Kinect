<?php

include(app_path().'/purify/HTMLPurifier.auto.php');

class ConversationController extends BaseController {
	
	public function showConversations() {
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
			return Redirect::to('/');
		}else{
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
		return Redirect::to('showConversation/'.$conversationId);
	}
	
	public function createConversation() {
		
		// creating note first
		$note = new Note;
		
			//PURIFY
			$pureconfig = HTMLPurifier_Config::createDefault();
			$purifier = new HTMLPurifier($pureconfig);
			$content = $purifier->purify(Input::get('content'));

		$note->content = $content;
		$note->user_id = Auth::user()->id;
		
		$note->save();
		
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
		
		// attach note to conversation
		$note->conversation_id = $conversation->id;
		
		$note->save();	
		
		return Redirect::to('conversations');
		
	}
	
	public function addToConversation() {
		$note = new Note;

			//PURIFY
				$pureconfig = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($pureconfig);
				$content = $purifier->purify(Input::get('content'));
		
		$note->content = $content;
		$note->user_id = Auth::user()->id;
		
		$note->save();
		
		$conversation = Conversation::find(Input::get('conversationID'));
		
		// attach note to conversation
		$note->conversation_id = $conversation->id;
		
		$note->save();	
		
		return Redirect::to('showConversation/'.$conversation->id);

		
	}
	
}

