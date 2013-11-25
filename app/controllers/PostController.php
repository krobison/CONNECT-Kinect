<?php

class PostController extends BaseController {
	
	public function createHelpPost() {
	
		try {
		$post = new Post;
		$post->user_id = Auth::user()->id;
		$post->anonymous = Input::get('anonymous');
		$post->post_type = '2';
		$post->help_request = Input::get('help_request');
		$post->content = Input::get('content');
		$post->save();
		return Redirect::back()->with('message', 'Your post has been successfully created.');
		}catch( Exception $e ) {
			return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
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