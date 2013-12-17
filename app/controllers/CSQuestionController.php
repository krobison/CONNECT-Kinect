<?php

class CSQuestionController extends BaseController {
	
	public function showCSQuestion() {
		return View::make('csQuestion')
			->with('user', Auth::user())
			->with('questions', Question::orderBy('created_at', 'DESC')->take(3)->get());
	}

	public function showQuestionDetails($id) {
		return View::make('questiondetails')
			->with('user', Auth::user())
			->with('question', Question::find($id));
	}

	public function createCommentQuestion() {

		try {

			$comment = new CommentQuestion;

			$comment->content = Input::get('content');
			$comment->user_id = Input::get('user_id');
			$comment->question_id = Input::get('question_id');

			$comment->save();

			return Redirect::back()->with('message', "You have commented successfully");

		} catch( Exception $e ) {

			dd($e);

			return Redirect::back()->with('message', "You have commented unsuccessfully");
		}
		
	}

}