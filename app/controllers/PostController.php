<?php

class PostController extends BaseController {
	
	public function createHelpRequestPost() {
	
		try {
			// First add a PostHelpRequest to the PostHelpRequest table
			$post_HR = new PostHelpRequest;
			$post_HR->anonymous = Input::get('anonymous');
			$post_HR->language = Input::get('language');
			$post_HR->code = Input::get('code');
			$post_HR->save();

			// Then add a Post to the Posts table, associating it with the PostHelpRequest through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post_HR->post()->save($post);
			
		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
			//return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
	public function createHelpOfferPost() {
	
		try {
			// First add a PostHelpOffer to the PostHelpOffertable
			$post_HO = new PostHelpOffer;
			$post_HO->availability = Input::get('availability');
			$post_HO->save();

			// Then add a Post to the Posts table, associating it with the PostHelpRequest through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post_HO->post()->save($post);
			
		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
		//	return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
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

	public function createComment() {
		try {

			$comment = new Comment;

			$comment->content = Input::get('content');
			$comment->user_id = Input::get('user_id');
			$comment->post_id = Input::get('post_id');

			$comment->save();

			return Redirect::back()->with('message', "You have commented successfully");

		} catch( Exception $e ) {

			dd($e);

			return Redirect::back()->with('message', "You have commented unsuccessfully");
		}
		
	}

	public function upvote() {
		$post = Post::find(Input::get('post_id'));
		$user = Auth::user();

		$upvote = in_array($user->id, $post->postupvotes->lists('user_id'));

		if ($upvote) {
			Upvote::where('user_id', '=', $user->id)->where('post_id', '=', $post->id)->delete();
			return Redirect::back()->with('message', "You have upvoted successfully");
		}

		else {
			try {

				$upvote = new Upvote;

				$upvote->user_id = Input::get('user_id');
				$upvote->post_id = Input::get('post_id');

				$upvote->save();

				return Redirect::back()->with('message', "You have upvoted successfully");

			} catch( Exception $e ) {

				dd($e);

				return Redirect::back()->with('message', "You have upvoted unsuccessfully");
			}
		}
		
	}

	public function showSinglePost($id) {
		$post = Post::find($id);
		$user = Auth::user();

		// $upvotes = Upvote::all();

		// $votes = $post->postupvotes;
		// //dd($votes);

		// $postUpvotes = array();

		// foreach ($upvotes as $upvote) {
		// 	if ($upvote->post_id == $id) {
		// 		array_push($postUpvotes, $upvote->user_id);
		// 	}
		// }

		// $upvote = in_array($user->id, $postUpvotes);
		// $upvoteCount = sizeof($postUpvotes);

		// $upvotes = $post->comments;

		// $upvote = in_array($user->id, $post->postupvotes->lists('user_id'));

		// if ($upvote) {
		// 	Upvote::where('user_id', '=', $user->id)->where('post_id', '=', $id)->delete();
		// }

		return View::make('singlepost')
			->with('user', $user)
			->with('post', $post);
	}

	public function showCSQuestion() {
		$post = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostQuestion')->take(1)->get();
		$post = $post->first();
		return View::make('singlepost')
			->with('user', Auth::user())
			->with('post', $post);
	}
	
	// Render the view
	public function showPost() {
		return View::make('post');
	}
	
	// Ajax. Returns all users as a JSON object.
	public function getUsers() {
		return  User::all();
	}
	
	// Form. Add user.
	public function addUser() {

		// Create a new User object
		$post = new Post;
	
		// Assign user attributes based on POST data
		//$user->name = $_POST[type]
		$post->user_id = $_POST['user_id'];
		$post->content = $_POST['content'];
		$post->upvotes = $_POST['upvotes'];

		// Save the user to the database
		$post->save();

		return;
	}
	
}