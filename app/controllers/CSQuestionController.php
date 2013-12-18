<?php

class CSQuestionController extends BaseController {
	
	public function showCSQuestion() {
		$post = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostQuestion')->take(1)->get();
		$post = $post->first();
		return View::make('singlepost')
			->with('user', Auth::user())
			->with('post', $post);
	}

	public function showQuestionDetails($id) {
		return View::make('questiondetails')
			->with('user', Auth::user())
			->with('question', Question::find($id));
	}

	public function showAllQuestions() {
		return View::make('allQuestions')
			->with('user', Auth::user())
			->with('questions', Question::orderBy('created_at', 'DESC')->get());
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