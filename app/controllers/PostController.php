<?php

class PostController extends BaseController {
	
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