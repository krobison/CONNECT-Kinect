<?php

class PostController extends BaseController {

	public function createComment() {
		try {
			$comment = new Comment;
			$comment->content = Input::get('content');
			$comment->user_id = Input::get('user_id');
			$comment->post_id = Input::get('post_id');
			$comment->language = Input::get('language');
			$comment->code = Input::get('code');
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
		
		if($post->postable_type == 'PostProject' && $post->postable->approved == '0' && $user->admin == '0') {
			return Redirect::to('newsfeed')->with('user', $user);
		}
	
		return View::make('singlepost')
			->with('user', $user)
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

	public function deleteUserComment() {
		$id = Input::get("id");
		$comment = Comment::find($id);
		$comment->delete();
		
		return Redirect::back()->with('message', 'You have successfully deleted the comment.');
	}

	public function saveEditComment() {
		$id = Input::get("id");
		$comment = Comment::find($id);
		$content = Input::get("toSave".$id);
		$code = Input::get("toSaveCode".$id);
		$newCode = Input::get("toSaveNewCode".$id);
		$language = Input::get("toSaveLanguage".$id);
		if (!empty($content)) {
			$comment->content = $content;
		}
		if (!empty($newCode)) {
			$comment->code = $newCode;
			$comment->language = $language;
		}
		if (!empty($code)) {
			if ($code == "hideCode") {
				$comment->code = "";
			} else{
				$comment->code = $code;
			}
		}
		$comment->save();

		return Redirect::back()->with('message', 'You have successfully updated your comment.');
	}
	
}