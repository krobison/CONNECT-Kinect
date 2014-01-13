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
		$log->event_type = "orevious CSQuestion accessed";
		$log->save();

		$posts = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostQuestion')->get();
		return View::make('newsfeed')
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
	
		try {
			// First add a PostHelpRequest to the PostHelpRequest table
			$post_Q = new PostQuestion;
			$post_Q->company_sponser = Input::get('company_sponser');
			$post_Q->save();

			// Then add a Post to the Posts table, associating it with the PostQuestion through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post_Q->post()->save($post);
			
		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
			//return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}

}