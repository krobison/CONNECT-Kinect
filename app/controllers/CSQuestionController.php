<?php

class CSQuestionController extends BaseController {
	
	public function showCSQuestion() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "CSQuestion accessed";
		$log->save();

		$post = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostQuestion')->take(1)->get();
		$post = $post->first();
		return View::make('singlepost')
			->with('user', Auth::user())
			->with('post', $post);
	}
	
	public function showPreviousQuestions() {
		$log = new CustomLog;
		$log->user_id = Auth::user()->id;
		$log->event_type = "Previous CSQuestion accessed";
		$log->save();

		$posts = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostQuestion')->get();
		return View::make('allQuestions')
			->with('user', Auth::user())
			->with('posts', $posts);
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

	public function createQuestionPost() {
	
		dd("hello");
	
		try {
		
			// Create A Post in the db
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content'));
			$post->language = Input::get('language');
			$post->code = Input::get('code');
			$post->postable_type = "PostQuestion";
			$post->save();

		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
			//return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}

}