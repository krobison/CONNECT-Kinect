<?php

class ConversationController extends BaseController {
	
	public function showConversations() {
		return View::make('conversations')
			->with('user', Auth::user())
			->with('conversations', Auth::user()->conversations);
	}
	
	public function composeConversation() {
		return View::make('composeConversation')
			->with('user', Auth::user());
	}
	
	public function showConversation($id) {
		return View::make('singleConversation')
			->with('user', Auth::user())
			->with('conversation', Conversation::find($id));
	}
	
	public function createConversation() {
		
		// creating note first
		$note = new Note;
		
		$note->content = Input::get('content');
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
		
		$note->content = Input::get('content');
		$note->user_id = Auth::user()->id;
		
		$note->save();
		
		$conversation = Conversation::find(Input::get('conversationID'));
		
		// attach note to conversation
		$note->conversation_id = $conversation->id;
		
		$note->save();	
		
		return Redirect::to('showConversation/'.$conversation->id);

		
	}
	
}
